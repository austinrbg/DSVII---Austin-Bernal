<?php

class Validator
{
    public static function requerido($valor)
    {
        return isset($valor) && trim((string)$valor) !== "";
    }

    public static function esEntero($valor)
    {
        return filter_var($valor, FILTER_VALIDATE_INT) !== false;
    }

    public static function esDecimal($valor)
    {
        return is_numeric($valor);
    }

    public static function esCorreo($valor)
    {
        return filter_var($valor, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function esFecha($valor)
    {
        if (!self::requerido($valor)) {
            return false;
        }

        $fecha = DateTime::createFromFormat('Y-m-d', $valor);

        return $fecha && $fecha->format('Y-m-d') === $valor;
    }

    public static function fechaFinValida($fechaInicio, $fechaFin)
    {
        if (!self::requerido($fechaFin)) {
            return true;
        }

        if (!self::esFecha($fechaInicio) || !self::esFecha($fechaFin)) {
            return false;
        }

        return strtotime($fechaFin) >= strtotime($fechaInicio);
    }

    public static function validarColaborador($datos)
    {
        $errores = [];

        if (!self::requerido($datos["identidad"] ?? "")) {
            $errores[] = "La identidad es obligatoria.";
        }

        if (!self::requerido($datos["nombre"] ?? "")) {
            $errores[] = "El nombre es obligatorio.";
        }

        if (!self::requerido($datos["apellido"] ?? "")) {
            $errores[] = "El apellido es obligatorio.";
        }

        if (!self::requerido($datos["edad"] ?? "")) {
            $errores[] = "La edad es obligatoria.";
        } elseif (!self::esEntero($datos["edad"]) || intval($datos["edad"]) < 18 || intval($datos["edad"]) > 75) {
            $errores[] = "La edad debe ser un número entre 18 y 75.";
        }

        if (!self::requerido($datos["tipo_sangre_id"] ?? "") || intval($datos["tipo_sangre_id"]) <= 0) {
            $errores[] = "Debe seleccionar el tipo de sangre.";
        }

        if (!self::requerido($datos["sexo_id"] ?? "") || intval($datos["sexo_id"]) <= 0) {
            $errores[] = "Debe seleccionar el sexo.";
        }

        if (!self::requerido($datos["nacionalidad_id"] ?? "") || intval($datos["nacionalidad_id"]) <= 0) {
            $errores[] = "Debe seleccionar la nacionalidad.";
        }

        if (!self::requerido($datos["ruta_id"] ?? "") || intval($datos["ruta_id"]) <= 0) {
            $errores[] = "Debe seleccionar la ruta del colaborador.";
        }

        if (!self::requerido($datos["correo"] ?? "")) {
            $errores[] = "El correo es obligatorio.";
        } elseif (!self::esCorreo($datos["correo"])) {
            $errores[] = "El correo no tiene un formato válido.";
        }

        if (!self::requerido($datos["celular"] ?? "")) {
            $errores[] = "El celular es obligatorio.";
        }

        if (isset($datos["empleado_activo"]) && intval($datos["empleado_activo"]) === 0) {
            if (!self::requerido($datos["motivo_baja"] ?? "")) {
                $errores[] = "Debe indicar el motivo de baja si el empleado está inactivo.";
            }
        }

        return $errores;
    }

    public static function validarPerfilLaboral($datos)
    {
        $errores = [];

        if (!self::requerido($datos["colaborador_id"] ?? "") || intval($datos["colaborador_id"]) <= 0) {
            $errores[] = "Debe seleccionar un colaborador.";
        }

        if (!self::requerido($datos["ocupacion_id"] ?? "") || intval($datos["ocupacion_id"]) <= 0) {
            $errores[] = "Debe seleccionar el puesto u ocupación.";
        }

        if (!self::requerido($datos["tipo_empleado_id"] ?? "") || intval($datos["tipo_empleado_id"]) <= 0) {
            $errores[] = "Debe seleccionar el tipo de empleado.";
        }

        if (!self::requerido($datos["planilla_id"] ?? "") || intval($datos["planilla_id"]) <= 0) {
            $errores[] = "Debe seleccionar la planilla.";
        }

        if (!self::requerido($datos["salario"] ?? "")) {
            $errores[] = "El salario es obligatorio.";
        } elseif (!self::esDecimal($datos["salario"]) || floatval($datos["salario"]) <= 0) {
            $errores[] = "El salario debe ser un número mayor que 0.";
        }

        if (!self::requerido($datos["fecha_inicio"] ?? "")) {
            $errores[] = "La fecha de inicio es obligatoria.";
        } elseif (!self::esFecha($datos["fecha_inicio"])) {
            $errores[] = "La fecha de inicio no tiene un formato válido.";
        }

        if (self::requerido($datos["fecha_fin"] ?? "")) {
            if (!self::esFecha($datos["fecha_fin"])) {
                $errores[] = "La fecha de fin no tiene un formato válido.";
            } elseif (!self::fechaFinValida($datos["fecha_inicio"], $datos["fecha_fin"])) {
                $errores[] = "La fecha de fin no puede ser menor que la fecha de inicio.";
            }
        }

        return $errores;
    }
}

?>