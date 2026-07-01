<?php

class SignatureService
{
    private const SECRET_KEY = "iTECH_CONTRATACIONES_2026_CLAVE_SEGURA";

    public static function generarFirma($datos)
    {
        $cadena = self::crearCadena($datos);

        return hash_hmac("sha256", $cadena, self::SECRET_KEY);
    }

    public static function verificarFirma($datos, $firmaGuardada)
    {
        $firmaNueva = self::generarFirma($datos);

        return hash_equals($firmaGuardada, $firmaNueva);
    }

    private static function crearCadena($datos)
    {
        ksort($datos);

        $partes = [];

        foreach ($datos as $clave => $valor) {
            $partes[] = $clave . "=" . $valor;
        }

        return implode("|", $partes);
    }
}

?>