<?php
    $numero1 = 7;
    $numero2 = 3;
    $resultado = $numero1 * $numero2; //$resultado contendrá 21
    echo "El resultado de la multiplicación es: " . $resultado . "\n";

    $numero3 = 2;
    $numero4 = 3;
    $numero5 = 4;

    $resultado3 = $numero3 + $numero4 * $numero5; 
    echo "\nEl resultado de la operación sin paréntesis es: " . $resultado3;

    $resultado2 = ($numero3 + $numero4) * $numero5; 
    echo "\n\nEl resultado de la operación con paréntesis es: " . $resultado2;
?>