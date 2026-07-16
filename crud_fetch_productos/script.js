document.addEventListener("DOMContentLoaded", function () {
    ListarProductos();

    document.getElementById("btnGuardar").addEventListener("click", function () {
        let id = document.getElementById("Id").value;

        if (id === "") {
            ejecutarAccion("Guardar");
        } else {
            ejecutarAccion("Modificar");
        }
    });

    document.getElementById("btnBuscar").addEventListener("click", function () {
        ejecutarAccion("Buscar");
    });

    document.getElementById("btnCancelar").addEventListener("click", function () {
        limpiarFormulario();
        ListarProductos();
    });

    document.getElementById("TextoBuscar").addEventListener("keyup", function () {
        if (this.value.trim() === "") {
            ListarProductos();
        }
    });
});

async function ejecutarAccion(accion) {
    switch (accion) {
        case "Guardar":
            await guardarProducto();
            break;

        case "Modificar":
            await modificarProducto();
            break;

        case "Buscar":
            await buscarProducto();
            break;

        case "Listar":
            await ListarProductos();
            break;

        default:
            Swal.fire("Error", "Acción no válida en JavaScript.", "error");
            break;
    }
}

function validarFormulario() {
    let codigo = document.getElementById("Codigo").value.trim();
    let producto = document.getElementById("Producto").value.trim();
    let precio = document.getElementById("Precio").value;
    let cantidad = document.getElementById("Cantidad").value;

    let errores = [];

    if (codigo === "") {
        errores.push("El código es obligatorio.");
    }

    if (producto === "") {
        errores.push("El nombre del producto es obligatorio.");
    }

    if (precio === "" || Number(precio) < 0) {
        errores.push("El precio debe ser mayor o igual a 0.");
    }

    if (cantidad === "" || Number(cantidad) < 0) {
        errores.push("La cantidad debe ser mayor o igual a 0.");
    }

    if (errores.length > 0) {
        Swal.fire({
            icon: "warning",
            title: "Validación",
            html: errores.join("<br>")
        });

        return false;
    }

    return true;
}

async function guardarProducto() {
    if (!validarFormulario()) {
        return;
    }

    let form = document.getElementById("formProducto");
    let datos = new FormData(form);

    datos.append("Accion", "Guardar");

    try {
        let respuesta = await fetch("registrar.php", {
            method: "POST",
            body: datos
        });

        if (!respuesta.ok) {
            throw new Error("Error en la petición HTTP.");
        }

        let resultado = await respuesta.json();

        mostrarMensaje(resultado);

        if (resultado.success) {
            limpiarFormulario();
            ListarProductos();
        }

    } catch (error) {
        Swal.fire("Error", "No se pudo guardar el producto: " + error.message, "error");
    }
}

async function modificarProducto() {
    if (!validarFormulario()) {
        return;
    }

    let form = document.getElementById("formProducto");
    let datos = new FormData(form);

    datos.append("Accion", "Modificar");

    try {
        let respuesta = await fetch("registrar.php", {
            method: "POST",
            body: datos
        });

        if (!respuesta.ok) {
            throw new Error("Error en la petición HTTP.");
        }

        let resultado = await respuesta.json();

        mostrarMensaje(resultado);

        if (resultado.success) {
            limpiarFormulario();
            ListarProductos();
        }

    } catch (error) {
        Swal.fire("Error", "No se pudo modificar el producto: " + error.message, "error");
    }
}

async function buscarProducto() {
    let texto = document.getElementById("TextoBuscar").value.trim();

    if (texto === "") {
        Swal.fire("Aviso", "Escriba un código o producto para buscar.", "warning");
        ListarProductos();
        return;
    }

    let datos = new FormData();
    datos.append("Accion", "Buscar");
    datos.append("Texto", texto);

    try {
        let respuesta = await fetch("registrar.php", {
            method: "POST",
            body: datos
        });

        if (!respuesta.ok) {
            throw new Error("Error en la petición HTTP.");
        }

        let resultado = await respuesta.json();

        if (resultado.success) {
            cargarTabla(resultado.data);
        } else {
            mostrarMensaje(resultado);
        }

    } catch (error) {
        Swal.fire("Error", "No se pudo realizar la búsqueda: " + error.message, "error");
    }
}

async function ListarProductos() {
    let datos = new FormData();
    datos.append("Accion", "Listar");

    try {
        let respuesta = await fetch("registrar.php", {
            method: "POST",
            body: datos
        });

        if (!respuesta.ok) {
            throw new Error("Error en la petición HTTP.");
        }

        let resultado = await respuesta.json();

        if (resultado.success) {
            cargarTabla(resultado.data);
        } else {
            mostrarMensaje(resultado);
        }

    } catch (error) {
        let tabla = document.getElementById("tablaProductos");

        tabla.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger">
                    Error al listar productos.
                </td>
            </tr>
        `;

        console.error(error);
    }
}

function cargarTabla(productos) {
    let tabla = document.getElementById("tablaProductos");

    tabla.innerHTML = "";

    if (productos.length === 0) {
        tabla.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">
                    No hay productos registrados.
                </td>
            </tr>
        `;
        return;
    }

    productos.forEach(function (item) {
        let fila = document.createElement("tr");

        let tdId = document.createElement("td");
        tdId.textContent = item.id;

        let tdCodigo = document.createElement("td");
        tdCodigo.textContent = item.codigo;

        let tdProducto = document.createElement("td");
        tdProducto.textContent = item.producto;

        let tdPrecio = document.createElement("td");
        tdPrecio.textContent = item.precio;

        let tdCantidad = document.createElement("td");
        tdCantidad.textContent = item.cantidad;

        let tdAccion = document.createElement("td");

        let botonEditar = document.createElement("button");
        botonEditar.className = "btn btn-warning btn-sm";
        botonEditar.textContent = "Editar";

        botonEditar.addEventListener("click", function () {
            cargarProductoEditar(
                item.id,
                item.codigo,
                item.producto,
                item.precio,
                item.cantidad
            );
        });

        tdAccion.appendChild(botonEditar);

        fila.appendChild(tdId);
        fila.appendChild(tdCodigo);
        fila.appendChild(tdProducto);
        fila.appendChild(tdPrecio);
        fila.appendChild(tdCantidad);
        fila.appendChild(tdAccion);

        tabla.appendChild(fila);
    });
}

function cargarProductoEditar(id, codigo, producto, precio, cantidad) {
    document.getElementById("Id").value = id;
    document.getElementById("Codigo").value = codigo;
    document.getElementById("Producto").value = producto;
    document.getElementById("Precio").value = precio;
    document.getElementById("Cantidad").value = cantidad;

    document.getElementById("btnGuardar").innerText = "Actualizar";
    document.getElementById("btnGuardar").classList.remove("btn-success");
    document.getElementById("btnGuardar").classList.add("btn-warning");

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

function limpiarFormulario() {
    document.getElementById("formProducto").reset();
    document.getElementById("Id").value = "";
    document.getElementById("TextoBuscar").value = "";

    document.getElementById("btnGuardar").innerText = "Registrar";
    document.getElementById("btnGuardar").classList.remove("btn-warning");
    document.getElementById("btnGuardar").classList.add("btn-success");
}

function mostrarMensaje(resultado) {
    let icono = "info";

    switch (resultado.success) {
        case true:
            icono = "success";
            break;

        case false:
            icono = "error";
            break;

        default:
            icono = "info";
            break;
    }

    let mensaje = resultado.message;

    if (resultado.errors && resultado.errors.length > 0) {
        mensaje += "<br><br>" + resultado.errors.join("<br>");
    }

    Swal.fire({
        icon: icono,
        title: resultado.accion,
        html: mensaje
    });
}