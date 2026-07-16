<?php
$pantalla = $_POST['pantalla'] ?? '';
$boton = $_POST['boton'] ?? '';
$resultado = '';

if ($boton) {
    if ($boton === '=') {
        // Reemplazar % por /100
        $expresion = preg_replace('/(\d+)%/', '($1/100)', $pantalla);
        try {
            eval('$resultado = ' . $expresion . ';');
            $pantalla = $resultado; // mostrar resultado en pantalla
        } catch (Throwable $e) {
            $pantalla = 'Error';
        }
    } elseif ($boton === 'C') {
        $pantalla = ''; // limpiar pantalla
    } else {
        $pantalla .= $boton; // concatenar el valor del botón
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
    <style>
        body { font-family: Arial; display: flex; justify-content: center; margin-top: 50px; background-color: #5cecec;}
        .calculadora { border: 2px solid #333; padding: 20px; width: 300px; background-color: #fff; }
        input, select, button { width: 94%; padding: 8px; margin: 10px 0; }
        button { background-color: #4CAF50; color: white; cursor: pointer; width: 100%; }
        .resultado { margin-top: 20px; font-size: 18px; font-weight: bold; }
        .calculadora h2 { text-align: center; font: bold 32px Times New Roman; color: #333; margin-bottom: 20px;  }
        .calculadora select { font-size: 16px; width: 100%  ;}
        .botone {display: grid; grid-template-columns: repeat(4, 1fr); /* 4 columnas iguales */ gap: 10px; /* espacio entre botones */ }

.botone button { width: 100%;padding: 15px;font-size: 18px; border: none; border-radius: 5px; background: #4CAF50; color: white; cursor: pointer;}

.botone button:hover { background: #45a049;}

    </style>
</head>
<body>
    
    <div class="calculadora">
        <h2>Calculadora</h2>
        <form method="POST">
            <input type="text" name="pantalla" placeholder="Ingrese la expresión (e.g., 5 + 3)" id ="pantalla" readonly value="<?php echo htmlspecialchars($pantalla); ?>">

            <div class="botone">
            <button type="submit" name="boton" value="7">7</button>
            <button type="submit" name="boton" value="8">8</button>
            <button type="submit" name="boton" value="9">9</button>
            <button type="submit" name="boton" value="+">+</button>   

            <button type="submit" name="boton" value="4">4</button>
            <button type="submit" name="boton" value="5">5</button>
            <button type="submit" name="boton" value="6">6</button>
            <button type="submit" name="boton" value="-">-</button>    

            <button type="submit" name="boton" value="1">1</button>
            <button type="submit" name="boton" value="2">2</button>
            <button type="submit" name="boton" value="3">3</button>
            <button type="submit" name="boton" value="*">X</button>

            <button type="submit" name="boton" value="0">0</button>
            <button type="submit" name="boton" value=".">.</button>
            <button type="submit" name="boton" value="%">%</button>
            <button type="submit" name="boton" value="/">÷</button>
        
            <button type="submit" name="boton" value="(">(</button>
            <button type="submit" name="boton" value=")">)</button>
            <button type="submit" name="boton" value="C">C</button>
            <button type="submit" name="boton" value="=">=</button>
            </div>
        </form>
        <?php if ($resultado !== ''): ?>
            <div class="resultado">Resultado: <?php echo $resultado; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>