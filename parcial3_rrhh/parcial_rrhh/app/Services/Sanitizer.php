<?php

class Sanitizer
{
    public static function limpiarTexto($valor)
    {
        $valor = trim($valor);
        $valor = strip_tags($valor);
        $valor = preg_replace('/\s+/', ' ', $valor);
        return $valor;
    }

    public static function nombreTitulo($valor)
    {
        $valor = self::limpiarTexto($valor);
        $valor = mb_strtolower($valor, 'UTF-8');
        return mb_convert_case($valor, MB_CASE_TITLE, 'UTF-8');
    }

    public static function limpiarCorreo($valor)
    {
        $valor = trim($valor);
        $valor = strtolower($valor);
        return filter_var($valor, FILTER_SANITIZE_EMAIL);
    }

    public static function limpiarCelular($valor)
    {
        $valor = trim($valor);
        return preg_replace('/[^0-9+\-\s]/', '', $valor);
    }

    public static function limpiarIdentidad($valor)
    {
        $valor = trim($valor);
        return preg_replace('/[^0-9A-Za-z\-]/', '', $valor);
    }

    public static function limpiarEntero($valor)
    {
        return filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
    }

    public static function limpiarDecimal($valor)
    {
        $valor = str_replace(',', '.', $valor);
        return filter_var($valor, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public static function limpiarFecha($valor)
    {
        return trim($valor);
    }

    public static function limpiarSelect($valor)
    {
        return intval($valor);
    }

    public static function limpiarMotivoBaja($valor)
    {
        $valor = self::limpiarTexto($valor);

        if ($valor === "") {
            return null;
        }

        return $valor;
    }

    public static function limpiarActivo($valor)
    {
        return $valor == "1" ? 1 : 0;
    }

    public static function escaparHTML($valor)
    {
        return htmlspecialchars($valor ?? "", ENT_QUOTES, "UTF-8");
    }
}

?>