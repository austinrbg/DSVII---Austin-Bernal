<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Sistemas Dinámicos - JQuery & POO</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
    /* --- Estilos Generales --- */
    body { 
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
        padding: 40px; 
        background-color: #f0f2f5; 
        color: #333;
        line-height: 1.6;
        margin: 0;
    }

    /* --- Encabezado y Menú Hamburguesa --- */
    header {
        background: #1a2a6c;
        padding: 15px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(26, 42, 108, 0.2);
        position: relative;
    }

    .header-title {
        color: white;
        margin: 0;
        font-size: 1.5rem;
        border: none;
        padding: 0;
    }

    .btn-hamburguesa {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding: 5px;
        z-index: 101;
    }

    .btn-hamburguesa span {
        display: block;
        width: 30px;
        height: 3px;
        background-color: white;
        border-radius: 2px;
        transition: transform 0.3s, opacity 0.3s;
    }

    /* Animación de la X cuando el menú está abierto */
    .btn-hamburguesa.abierto span:nth-child(1) {
        transform: translateY(9px) rotate(45deg);
    }
    .btn-hamburguesa.abierto span:nth-child(2) {
        opacity: 0;
    }
    .btn-hamburguesa.abierto span:nth-child(3) {
        transform: translateY(-9px) rotate(-45deg);
    }

    /* Menú desplegable */
    nav { 
        display: none; /* Oculto por defecto */
        position: absolute;
        top: 70px;
        right: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        overflow: hidden;
        z-index: 100;
        min-width: 250px;
    }

    .btn-menu { 
        display: block;
        width: 100%;
        background: transparent; 
        color: #333; 
        border: none; 
        border-bottom: 1px solid #eee;
        padding: 15px 20px; 
        cursor: pointer; 
        font-weight: 600;
        text-align: left;
        transition: background 0.3s;
        font-size: 1rem;
    }

    .btn-menu:last-child {
        border-bottom: none;
    }

    .btn-menu:hover {
        background: #f8f9fa;
        color: #1a2a6c;
    }

    .btn-menu.activo { 
        background: #f39c12; 
        color: white;
    }

    /* --- Contenedores de Sección --- */
    .seccion { 
        background: white; 
        padding: 35px; 
        border-radius: 15px; 
        box-shadow: 0 8px 30px rgba(0,0,0,0.05); 
        max-width: 1000px;
        margin: 0 auto;
    }

    h2 { 
        color: #1a2a6c; 
        border-bottom: 2px solid #f39c12; 
        display: inline-block; 
        margin-bottom: 25px;
        padding-bottom: 5px;
    }

    /* --- Ejemplo 1: Tareas --- */
    #inputTarea {
        padding: 12px;
        border: 2px solid #ddd;
        border-radius: 8px;
        width: 300px;
        margin-right: 10px;
        transition: border-color 0.3s;
    }

    #inputTarea:focus {
        border-color: #1a2a6c;
        outline: none;
    }

    #btnAgregar {
        background-color: #1a2a6c;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    .tarea-item { 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        padding: 15px; 
        margin-top: 10px;
        background: #f8f9fa;
        border-radius: 10px;
        transition: background 0.3s;
    }

    .tarea-item:hover { background: #f1f3f5; }

    .texto-tarea { font-size: 1.1rem; margin-left: 10px; }
    .completada { text-decoration: line-through; color: #adb5bd; font-style: italic; }

    /* --- Ejemplo 2: Carrito y Catálogo --- */
    .tienda-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .producto-card { 
        background: #fff;
        border: 1px solid #e9ecef; 
        padding: 20px; 
        border-radius: 12px; 
        text-align: center; 
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .producto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .add-cart {
        margin-top: 15px;
        background: #1a2a6c;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .factura-box {
        background: #fff;
        border: 2px dashed #1a2a6c;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }

    /* --- Ejemplo 3 y Tablas --- */
    table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0;
        margin-top: 20px; 
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #dee2e6;
    }

    th { 
        background-color: #1a2a6c; 
        color: white; 
        padding: 15px; 
        text-align: left; 
    }

    td { padding: 15px; border-bottom: 1px solid #dee2e6; }
    tr:last-child td { border-bottom: none; }
    tr:nth-child(even) { background-color: #f8f9fa; }

    #btnCargarTablas {
        background-color: #1a2a6c;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
    }

    /* Estilos de Imágenes*/
    .img-laptop, .img-monitor, .img-teclado, .img-mouse {
        display: block;
        margin: 0 auto 15px;
        border-radius: 8px;
        width: 100%;
        height: 180px; 
        object-fit: contain; 
        background-color: #f8f9fa; 
        padding: 10px; 
        transition: transform 0.3s ease;
    }

    .producto-card:hover img {
        transform: scale(1.05);
    }

</style>
</head>
<body>

    <header>
        <h2 class="header-title">Menú Interactivo</h2>
        <button id="btnHamburguesa" class="btn-hamburguesa">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <nav id="menuNavegacion">
            <button class="btn-menu" data-target="ej1">1. Tareas Inteligentes</button>
            <button class="btn-menu" data-target="ej2">2. Carrito de Ventas</button>
            <button class="btn-menu" data-target="ej3">3. Listado de Usuarios</button>
        </nav>
    </header>

    <div id="ej1" class="contenido-ejemplo">
        <div class="seccion">
            <h2>Gestor de Tareas</h2>
            <p><small>Nota: Solo puedes eliminar tareas que hayan sido marcadas como completadas.</small></p>
            <input type="text" id="inputTarea" placeholder="¿Qué hay que hacer?">
            <button id="btnAgregar">Agregar</button>
            <div id="listaTareasContainer" style="margin-top: 20px;"></div>
        </div>
    </div>

    <div id="ej2" class="contenido-ejemplo">
        <div class="seccion">
            <h2>Catálogo de Hardware</h2>
            <div id="tienda" class="tienda-grid"></div>
            <div style="margin-top:20px; border-top: 2px solid #eee; padding-top:15px;">
                <h3>Resumen de Compra</h3>
                <div id="listaCarrito"></div>
                <h4>Total: $<span id="totalVenta">0.00</span></h4>
                <button id="btnFinalizar" style="background:#27ae60; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer;">
                    Finalizar y Pagar
                </button>
            </div>
        </div>
    </div>

    <div id="ej3" class="contenido-ejemplo">
        <div class="seccion">
            <h2>Directorio de Usuarios</h2>
            <button id="btnCargarTablas" style="background:#1a2a6c; color:white; padding:10px; border:none; border-radius:5px; cursor:pointer; display:block; margin: 10px 0 20px 0;">
                Cargar Datos desde Servidor
            </button>
            <div id="formUsuarios" style="display:none; background:#fff; padding:15px; border-radius:8px; margin-bottom:15px; border:1px solid #ddd;">
                <h4 style="margin-top:0; color:#1a2a6c;">Registrar Nuevo Usuario</h4>
                <input type="text" id="inNombre" placeholder="Nombre" style="padding:8px; width:120px;">
                <input type="text" id="inApellido" placeholder="Apellido" style="padding:8px; width:120px;">
                <input type="email" id="inCorreo" placeholder="Correo" style="padding:8px; width:180px;">
                <button id="btnGuardarUsuario" style="background:#27ae60; color:white; padding:9px 15px; border:none; border-radius:5px; cursor:pointer;">
                    Guardar
                </button>
            </div>
            <div id="tablaContainer"></div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // =====================================================================
        // CLASES POO (Mantenidas exactamente igual)
        // =====================================================================
        class Utilidades {
            static generarId() { return Math.floor(Math.random() * 9000) + 1000; }
            static formatearPrecio(precio) { return parseFloat(precio).toFixed(2); }
            static textoValido(texto) { return texto && texto.trim().length > 0; }
        }

        class ComponenteUI {
            constructor() {
                if (new.target === ComponenteUI) {
                    throw new Error('ComponenteUI es una clase abstracta simulada.');
                }
            }
            render() {
                throw new Error('Debe implementar el método render().');
            }
        }

        class Tarea {
            constructor(descripcion) {
                this.id = Utilidades.generarId();
                this.descripcion = descripcion;
                this.completada = false;
            }
            alternarEstado() { this.completada = !this.completada; }
        }

        class GestorTareas {
            constructor() { this.tareas = []; }
            agregar(descripcion) {
                const tarea = new Tarea(descripcion);
                this.tareas.push(tarea);
                return tarea;
            }
            buscar(id) { return this.tareas.find(t => t.id === id); }
            eliminar(id) { this.tareas = this.tareas.filter(t => t.id !== id); }
        }

        const gestorDeTareas = new GestorTareas();

        class Producto {
            constructor(id, nombre, precio, imagen, cssClass) {
                this.id = id; this.nombre = nombre; this.precio = precio; this.imagen = imagen; this.cssClass = cssClass;
            }
        }

        class TarjetaProducto extends ComponenteUI {
            constructor(producto) {
                super();
                this.producto = producto;
            }
            render() {
                return `
                <div class="producto-card">
                    ${this.producto.imagen ? `<img src="${this.producto.imagen}" alt="${this.producto.nombre}" class="${this.producto.cssClass}">` : ''}
                    <b><br>${this.producto.nombre}</b><br>$${Utilidades.formatearPrecio(this.producto.precio)}<br>
                    <button class="add-cart" data-id="${this.producto.id}">Agregar</button>
                </div>`;
            }
        }

        class Carrito {
            constructor() { this.items = {}; }
            agregar(producto) {
                if (this.items[producto.id]) { this.items[producto.id].cantidad++; } 
                else { this.items[producto.id] = { producto: producto, cantidad: 1 }; }
            }
            calcularSubtotal() {
                let suma = 0;
                Object.values(this.items).forEach(item => { suma += item.producto.precio * item.cantidad; });
                return suma;
            }
            vaciar() { this.items = {}; }
            estaVacio() { return Object.keys(this.items).length === 0; }
        }

        const carritoDeCompras = new Carrito();
        
        const catalogo = [
            new Producto(1, 'Dell Latitude 7490', 450, 'https://geeky.sfo2.cdn.digitaloceanspaces.com/geekydrop_production/iNGiRgSo-_1760196874606.jpeg', 'img-laptop'),
            new Producto(2, 'Monitor 24 MSI', 120, 'https://www.yoytec.com/web/image/product.product/50521/image_1920?unique=1', 'img-monitor'),
            new Producto(3, 'Teclado Mecánico', 85, 'https://www.multimax.net/cdn/shop/files/PSN0110120_1200x.jpg?v=1752857224', 'img-teclado'),
            new Producto(4, 'Mouse Inalámbrico', 30, 'https://www.panafoto.com/media/catalog/product/cache/d9d0e56184dc11f5b1bf90662cef36b8/1/5/153397-001_v38mu6jeglfyowzk.jpg', 'img-mouse')
        ];
        
        class Usuario {
            constructor(id, nombre, apellido, correo) {
                this.id = id; this.nombre = nombre; this.apellido = apellido; this.correo = correo;
            }
        }

        class ServicioUsuarios {
            static obtenerUsuarios() {
                return $.ajax({ url: '/api.php', method: 'GET', dataType: 'json' });
            }
            static guardarUsuario(usuario) {
                return $.ajax({
                    url: '/api.php', method: 'POST',
                    data: { nombre: usuario.nombre, apellido: usuario.apellido, email: usuario.correo },
                    dataType: 'json'
                });
            }
        }

        // =====================================================================
        // INTERACCIÓN CON EL DOM Y JQUERY
        // =====================================================================
        $(document).ready(function() {
            
            // Lógica para el menú hamburguesa y navegación entre ejemplos
            
            // 1. Abrir/Cerrar el menú al hacer clic en el botón
            $('#btnHamburguesa').click(function(e) {
                e.stopPropagation(); // Evita que el click se propague al documento
                $(this).toggleClass('abierto');
                $('#menuNavegacion').slideToggle(200);
            });

            // 2. Cerrar el menú si se hace clic fuera de él
            $(document).click(function(e) {
                if (!$(e.target).closest('#menuNavegacion').length && $('#menuNavegacion').is(':visible')) {
                    $('#menuNavegacion').slideUp(200);
                    $('#btnHamburguesa').removeClass('abierto');
                }
            });

            // 3. Cambiar de pestaña y ocultar el menú automáticamente
            $('.btn-menu').click(function() {
                $('.btn-menu').removeClass('activo');
                $(this).addClass('activo');
                
                // Muestra contenido
                $('.contenido-ejemplo').hide();
                $('#' + $(this).data('target')).fadeIn();
                
                // Oculta menú 
                $('#menuNavegacion').slideUp(200);
                $('#btnHamburguesa').removeClass('abierto');
                
            }).first().trigger('click');


            // --- EVENTOS EJEMPLO 1 (TAREAS) ---
            $('#btnAgregar').click(function() {
                const texto = $('#inputTarea').val();
                if (!Utilidades.textoValido(texto)) return; 

                const nuevaTarea = gestorDeTareas.agregar(texto); 
                
                const itemHtml = `
                    <div class="tarea-item" id="item-${nuevaTarea.id}">
                        <div>
                            <input type="checkbox" class="check-tarea" data-id="${nuevaTarea.id}">
                            <span class="texto-tarea">${nuevaTarea.descripcion}</span>
                        </div>
                        <button class="btn-del" data-id="${nuevaTarea.id}" style="color:red; background:none; border:none; cursor:pointer;">Eliminar</button>
                    </div>`;
                
                $('#listaTareasContainer').append(itemHtml);
                $('#inputTarea').val('').focus();
            });

            $(document).on('change', '.check-tarea', function() {
                const id = $(this).data('id');
                const tarea = gestorDeTareas.buscar(id); 
                tarea.alternarEstado(); 

                const parent = $(`#item-${id}`);
                if (tarea.completada) { parent.find('.texto-tarea').addClass('completada'); } 
                else { parent.find('.texto-tarea').removeClass('completada'); }
            });

            $(document).on('click', '.btn-del', function() {
                const id = $(this).data('id');
                const tarea = gestorDeTareas.buscar(id);

                if (!tarea.completada) {
                    alert("⚠️ La tarea debe estar marcada como completada antes de eliminarse.");
                    return;
                }

                gestorDeTareas.eliminar(id); 
                $(`#item-${id}`).fadeOut(300, function() { $(this).remove(); }); 
            });


            // --- EVENTOS EJEMPLO 2 (CARRITO) ---
            catalogo.forEach(p => {
                const tarjeta = new TarjetaProducto(p);
                $('#tienda').append(tarjeta.render()); 
            });

            $(document).on('click', '.add-cart', function() {
                const id = $(this).data('id');
                const productoSeleccionado = catalogo.find(p => p.id === id);
                
                carritoDeCompras.agregar(productoSeleccionado); 
                renderFactura();
            });

            function renderFactura() {
                if(carritoDeCompras.estaVacio()) {
                    $('#listaCarrito').empty();
                    $('#totalVenta').text("0.00");
                    return;
                }

                let tabla = `
                    <table style="width:100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border:1px solid #ddd; padding:8px;">Producto</th>
                                <th style="border:1px solid #ddd; padding:8px;">Cantidad</th>
                                <th style="border:1px solid #ddd; padding:8px;">Precio Unitario</th>
                                <th style="border:1px solid #ddd; padding:8px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                Object.values(carritoDeCompras.items).forEach(item => {
                    const sub = item.producto.precio * item.cantidad;
                    tabla += `
                        <tr>
                            <td style="border:1px solid #ddd; padding:8px;">${item.producto.nombre}</td>
                            <td style="border:1px solid #ddd; padding:8px;">${item.cantidad}</td>
                            <td style="border:1px solid #ddd; padding:8px;">$${Utilidades.formatearPrecio(item.producto.precio)}</td>
                            <td style="border:1px solid #ddd; padding:8px;">$${Utilidades.formatearPrecio(sub)}</td>
                        </tr>
                    `;
                });
                tabla += `</tbody></table>`;

                const subtotal = carritoDeCompras.calcularSubtotal();
                const impuesto = subtotal * 0.07;
                const totalFinal = subtotal + impuesto;

                $('#listaCarrito').html(`
                    ${tabla}
                    <h4 style="margin-bottom:5px;">Subtotal: $${Utilidades.formatearPrecio(subtotal)}</h4>
                    <h4 style="margin-top:0;">Impuesto (7%): $${Utilidades.formatearPrecio(impuesto)}</h4>
                    <h3>Total a Pagar: $${Utilidades.formatearPrecio(totalFinal)}</h3>
                `);

                $('#totalVenta').text(Utilidades.formatearPrecio(totalFinal));
            }

            $('#btnFinalizar').click(function() {
                if(carritoDeCompras.estaVacio()) return alert("El carrito está vacío");

                alert("¡Venta completada con éxito! Se ha reiniciado el carrito.");
                carritoDeCompras.vaciar(); 
                renderFactura(); 
            });


            // --- EVENTOS EJEMPLO 3 (USUARIOS AJAX) ---
            $('#btnCargarTablas').click(function() {
                const $cont = $('#tablaContainer');
                $cont.html('<p>Solicitando datos al servidor...</p>');
                
                ServicioUsuarios.obtenerUsuarios().done(function(usuariosRecibidos) {
                    let tabla = `
                        <table id="tablaUsuarios">
                            <thead>
                                <tr><th>ID Único</th><th>Nombre</th><th>Apellido</th><th>Correo</th></tr>
                            </thead>
                            <tbody>`;
                    
                    usuariosRecibidos.forEach(u => {
                        tabla += `<tr><td>#${u.id}</td><td>${u.nombre}</td><td>${u.apellido}</td><td>${u.email}</td></tr>`;
                    });

                    tabla += `</tbody></table>`;
                    $cont.hide().html(tabla).fadeIn(500);
                    
                    $('#formUsuarios').fadeIn(500); 
                });
            });

            $('#btnGuardarUsuario').click(function() {
                const n = $('#inNombre').val();
                const a = $('#inApellido').val();
                const c = $('#inCorreo').val();

                if(!Utilidades.textoValido(n) || !Utilidades.textoValido(a) || !Utilidades.textoValido(c)) {
                    return alert("Por favor, llena todos los campos.");
                }

                const btn = $(this);
                btn.text('Guardando...').prop('disabled', true); 

                const nuevoUsuario = new Usuario(Utilidades.generarId(), n, a, c);

                ServicioUsuarios.guardarUsuario(nuevoUsuario).done(function(u) {
                    const filaHtml = `<tr style="background:#e8f8f5;"><td>#${u.id}</td><td>${u.nombre}</td><td>${u.apellido}</td><td>${u.email}</td></tr>`;
                    $('#tablaUsuarios tbody').append(filaHtml);
                    
                    $('#inNombre').val('');
                    $('#inApellido').val('');
                    $('#inCorreo').val('');
                    btn.text('Guardar').prop('disabled', false);
                });
            });
        });
    </script>
</body>
</html>