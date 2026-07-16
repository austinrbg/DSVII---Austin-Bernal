<?php
// app/Helpers/SanitizarEntrada.php

class SanitizarEntrada {

    // 1. Método original que requiere el objLoginAdmin.php de la profesora
    public static function limpiarCadena($cadena) {
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        // Usa htmlspecialchars para prevenir XSS [cite: 18, 150, 151]
        return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
    }

    // 2. Método para texto general en el registro
    public static function sanitizarTexto($cadena) {
        return self::limpiarCadena($cadena);
    }

    // 3. Método para limpiar correos electrónicos [cite: 25, 28]
    public static function sanitizarEmail($email) {
        $email = trim($email);
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    // 4. Método para validar el formato del correo electrónico [cite: 54, 55]
    public static function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
?>