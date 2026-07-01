<?php

require_once __DIR__ . "/../Config/Database.php";
require_once __DIR__ . "/../Services/Sanitizer.php";
require_once __DIR__ . "/../Services/Validator.php";
require_once __DIR__ . "/../Services/SignatureService.php";

class PerfilLaboral
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private function prepararDatos($datos)
{
    $fechaFin = Sanitizer::limpiarFecha($datos["fecha_fin"] ?? "");
    $cargoActivo = Sanitizer::limpiarActivo($datos["cargo_activo"] ?? 1);

    if ($fechaFin !== "") {
        $cargoActivo = 0;
    }

    return [
        "colaborador_id" => Sanitizer::limpiarSelect($datos["colaborador_id"] ?? 0),
        "ocupacion_id" => Sanitizer::limpiarSelect($datos["ocupacion_id"] ?? 0),
        "tipo_empleado_id" => Sanitizer::limpiarSelect($datos["tipo_empleado_id"] ?? 0),
        "planilla_id" => Sanitizer::limpiarSelect($datos["planilla_id"] ?? 0),
        "salario" => Sanitizer::limpiarDecimal($datos["salario"] ?? ""),
        "fecha_inicio" => Sanitizer::limpiarFecha($datos["fecha_inicio"] ?? ""),
        "fecha_fin" => $fechaFin,
        "cargo_activo" => $cargoActivo
    ];
}

    private function prepararDatosFirma($datos)
    {
        return [
            "colaborador_id" => $datos["colaborador_id"],
            "ocupacion_id" => $datos["ocupacion_id"],
            "tipo_empleado_id" => $datos["tipo_empleado_id"],
            "planilla_id" => $datos["planilla_id"],
            "salario" => number_format((float)$datos["salario"], 2, ".", ""),
            "fecha_inicio" => $datos["fecha_inicio"],
            "fecha_fin" => $datos["fecha_fin"] ?? "",
            "cargo_activo" => $datos["cargo_activo"]
        ];
    }

    private function desactivarCargosAnteriores($colaboradorId, $idExcluir = null)
    {
        if ($idExcluir === null) {
            $sql = "SELECT * FROM perfiles_laborales 
                    WHERE colaborador_id = ? AND cargo_activo = 1";
            $params = [intval($colaboradorId)];
        } else {
            $sql = "SELECT * FROM perfiles_laborales 
                    WHERE colaborador_id = ? AND cargo_activo = 1 AND id != ?";
            $params = [intval($colaboradorId), intval($idExcluir)];
        }

        $perfilesActivos = $this->db->select($sql, $params);

        foreach ($perfilesActivos as $perfil) {
            $fechaFin = $perfil["fecha_fin"];

            if ($fechaFin === null || $fechaFin === "") {
                $fechaFin = date("Y-m-d");
            }

            $datosFirma = $this->prepararDatosFirma([
                "colaborador_id" => $perfil["colaborador_id"],
                "ocupacion_id" => $perfil["ocupacion_id"],
                "tipo_empleado_id" => $perfil["tipo_empleado_id"],
                "planilla_id" => $perfil["planilla_id"],
                "salario" => $perfil["salario"],
                "fecha_inicio" => $perfil["fecha_inicio"],
                "fecha_fin" => $fechaFin,
                "cargo_activo" => 0
            ]);

            $firmaNueva = SignatureService::generarFirma($datosFirma);

            $this->db->updateSeguro(
                "perfiles_laborales",
                [
                    "cargo_activo" => 0,
                    "fecha_fin" => $fechaFin,
                    "firma_integridad" => $firmaNueva
                ],
                [
                    "id" => $perfil["id"]
                ]
            );
        }

        return true;
    }

    public function guardar($datos)
    {
        $datosLimpios = $this->prepararDatos($datos);

        $errores = Validator::validarPerfilLaboral($datosLimpios);

        if (!empty($errores)) {
            return [
                "success" => false,
                "message" => "Hay errores en los datos laborales.",
                "errors" => $errores
            ];
        }

        $colaborador = $this->db->selectOne(
            "SELECT id FROM datospersonales WHERE id = ?",
            [intval($datosLimpios["colaborador_id"])]
        );

        if (!$colaborador) {
            return [
                "success" => false,
                "message" => "El colaborador seleccionado no existe.",
                "errors" => ["Debe seleccionar un colaborador válido."]
            ];
        }

        if (intval($datosLimpios["cargo_activo"]) === 1) {
            $this->desactivarCargosAnteriores($datosLimpios["colaborador_id"]);
        }

        if ($datosLimpios["fecha_fin"] === "") {
            $datosLimpios["fecha_fin"] = null;
        }

        $datosFirma = $this->prepararDatosFirma($datosLimpios);

        $datosBD = [
            "colaborador_id" => intval($datosLimpios["colaborador_id"]),
            "ocupacion_id" => intval($datosLimpios["ocupacion_id"]),
            "tipo_empleado_id" => intval($datosLimpios["tipo_empleado_id"]),
            "planilla_id" => intval($datosLimpios["planilla_id"]),
            "salario" => number_format((float)$datosLimpios["salario"], 2, ".", ""),
            "fecha_inicio" => $datosLimpios["fecha_inicio"],
            "fecha_fin" => $datosLimpios["fecha_fin"],
            "cargo_activo" => intval($datosLimpios["cargo_activo"]),
            "firma_integridad" => SignatureService::generarFirma($datosFirma)
        ];

        $resultado = $this->db->insertSeguro("perfiles_laborales", $datosBD);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Perfil laboral guardado correctamente.",
                "errors" => [],
                "id" => $this->db->lastInsertId()
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo guardar el perfil laboral.",
            "errors" => ["Error al insertar en la base de datos."]
        ];
    }

    public function actualizar($id, $datos)
    {
        $id = intval($id);
        $datosLimpios = $this->prepararDatos($datos);

        $errores = Validator::validarPerfilLaboral($datosLimpios);

        if ($id <= 0) {
            $errores[] = "El ID del perfil laboral no es válido.";
        }

        if (!empty($errores)) {
            return [
                "success" => false,
                "message" => "Hay errores en los datos laborales.",
                "errors" => $errores
            ];
        }

        $perfilActual = $this->obtenerPorId($id);

        if (!$perfilActual) {
            return [
                "success" => false,
                "message" => "El perfil laboral no existe.",
                "errors" => ["No se encontró el perfil seleccionado."]
            ];
        }

        $colaborador = $this->db->selectOne(
            "SELECT id FROM datospersonales WHERE id = ?",
            [intval($datosLimpios["colaborador_id"])]
        );

        if (!$colaborador) {
            return [
                "success" => false,
                "message" => "El colaborador seleccionado no existe.",
                "errors" => ["Debe seleccionar un colaborador válido."]
            ];
        }

        if (intval($datosLimpios["cargo_activo"]) === 1) {
            $this->desactivarCargosAnteriores($datosLimpios["colaborador_id"], $id);
        }

        if ($datosLimpios["fecha_fin"] === "") {
            $datosLimpios["fecha_fin"] = null;
        }

        $datosFirma = $this->prepararDatosFirma($datosLimpios);

        $datosBD = [
            "colaborador_id" => intval($datosLimpios["colaborador_id"]),
            "ocupacion_id" => intval($datosLimpios["ocupacion_id"]),
            "tipo_empleado_id" => intval($datosLimpios["tipo_empleado_id"]),
            "planilla_id" => intval($datosLimpios["planilla_id"]),
            "salario" => number_format((float)$datosLimpios["salario"], 2, ".", ""),
            "fecha_inicio" => $datosLimpios["fecha_inicio"],
            "fecha_fin" => $datosLimpios["fecha_fin"],
            "cargo_activo" => intval($datosLimpios["cargo_activo"]),
            "firma_integridad" => SignatureService::generarFirma($datosFirma)
        ];

        $resultado = $this->db->updateSeguro("perfiles_laborales", $datosBD, ["id" => $id]);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Perfil laboral actualizado correctamente.",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo actualizar el perfil laboral.",
            "errors" => ["Error al actualizar en la base de datos."]
        ];
    }

    public function listar()
    {
        $sql = "SELECT 
                    p.id,
                    p.colaborador_id,
                    CONCAT(d.Nombre, ' ', d.Apellido) AS colaborador,
                    d.identidad,
                    o.OCUPACION AS ocupacion,
                    te.Nombre AS tipo_empleado,
                    tp.nombre AS planilla,
                    p.salario,
                    p.fecha_inicio,
                    p.fecha_fin,
                    p.cargo_activo,
                    p.firma_integridad,
                    p.fecha_registro
                FROM perfiles_laborales p
                INNER JOIN datospersonales d ON p.colaborador_id = d.id
                INNER JOIN cat_ocupaciones o ON p.ocupacion_id = o.C_OCUP
                INNER JOIN cat_tipoempleado te ON p.tipo_empleado_id = te.id
                INNER JOIN cat_tipos_planilla tp ON p.planilla_id = tp.id
                ORDER BY p.id DESC";

        return $this->db->select($sql);
    }

    public function listarPorColaborador($colaboradorId)
    {
        $sql = "SELECT 
                    p.id,
                    p.colaborador_id,
                    CONCAT(d.Nombre, ' ', d.Apellido) AS colaborador,
                    d.identidad,
                    o.OCUPACION AS ocupacion,
                    te.Nombre AS tipo_empleado,
                    tp.nombre AS planilla,
                    p.salario,
                    p.fecha_inicio,
                    p.fecha_fin,
                    p.cargo_activo,
                    p.firma_integridad,
                    p.fecha_registro
                FROM perfiles_laborales p
                INNER JOIN datospersonales d ON p.colaborador_id = d.id
                INNER JOIN cat_ocupaciones o ON p.ocupacion_id = o.C_OCUP
                INNER JOIN cat_tipoempleado te ON p.tipo_empleado_id = te.id
                INNER JOIN cat_tipos_planilla tp ON p.planilla_id = tp.id
                WHERE p.colaborador_id = ?
                ORDER BY p.id DESC";

        return $this->db->select($sql, [intval($colaboradorId)]);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM perfiles_laborales WHERE id = ?";

        return $this->db->selectOne($sql, [intval($id)]);
    }

    public function verificarIntegridad($id)
    {
        $perfil = $this->obtenerPorId($id);

        if (!$perfil) {
            return [
                "success" => false,
                "message" => "Perfil laboral no encontrado.",
                "integridad" => "NO_VERIFICADO"
            ];
        }

        $datosFirma = $this->prepararDatosFirma([
            "colaborador_id" => $perfil["colaborador_id"],
            "ocupacion_id" => $perfil["ocupacion_id"],
            "tipo_empleado_id" => $perfil["tipo_empleado_id"],
            "planilla_id" => $perfil["planilla_id"],
            "salario" => $perfil["salario"],
            "fecha_inicio" => $perfil["fecha_inicio"],
            "fecha_fin" => $perfil["fecha_fin"] ?? "",
            "cargo_activo" => $perfil["cargo_activo"]
        ]);

        $esValida = SignatureService::verificarFirma(
            $datosFirma,
            $perfil["firma_integridad"]
        );

        if ($esValida) {
            return [
                "success" => true,
                "message" => "La firma de integridad es válida.",
                "integridad" => "VALIDO"
            ];
        }

        return [
            "success" => false,
            "message" => "La firma de integridad no coincide. Los datos pudieron ser alterados.",
            "integridad" => "ALTERADO"
        ];
    }

    public function reporteGeneral()
{
    $sql = "SELECT 
                d.id AS colaborador_id,
                p.id AS perfil_id,
                d.identidad,
                d.Nombre AS nombre,
                d.Apellido AS apellido,
                d.Edad AS edad,
                ts.Nombre AS tipo_sangre,
                sx.nombre AS sexo,
                n.nombre AS nacionalidad,
                r.Nombre AS ruta,
                d.Email1 AS correo,
                d.Celular AS celular,
                CASE 
                    WHEN d.Empleado_Activo = 1 THEN 'Activo'
                    ELSE 'Inactivo'
                END AS estado_empleado,
                mt.MOTIVO AS motivo_terminacion,
                d.Motivo_Baja AS motivo_baja,
                o.OCUPACION AS ocupacion,
                te.Nombre AS tipo_empleado,
                tp.nombre AS planilla,
                p.salario,
                p.fecha_inicio,
                p.fecha_fin,
                CASE 
                    WHEN p.cargo_activo = 1 THEN 'Activo'
                    ELSE 'Inactivo'
                END AS estado_cargo,
                p.firma_integridad
            FROM datospersonales d
            LEFT JOIN perfiles_laborales p ON d.id = p.colaborador_id
            LEFT JOIN cat_tiposangre ts ON d.tipo_sangre_id = ts.id
            LEFT JOIN cat_sexo sx ON d.sexo_id = sx.id
            LEFT JOIN cat_nacionalidades n ON d.nacionalidad_id = n.id
            LEFT JOIN cat_rutas r ON d.ruta_id = r.id
            LEFT JOIN cat_motivos_terminacion mt ON d.motivo_terminacion_id = mt.C_TERMINACION
            LEFT JOIN cat_ocupaciones o ON p.ocupacion_id = o.C_OCUP
            LEFT JOIN cat_tipoempleado te ON p.tipo_empleado_id = te.id
            LEFT JOIN cat_tipos_planilla tp ON p.planilla_id = tp.id
            ORDER BY d.id DESC, p.id DESC";

    return $this->db->select($sql);
}
}

?>