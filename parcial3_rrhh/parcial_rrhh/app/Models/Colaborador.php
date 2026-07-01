<?php

require_once __DIR__ . "/../Config/Database.php";
require_once __DIR__ . "/../Services/Sanitizer.php";
require_once __DIR__ . "/../Services/Validator.php";

class Colaborador
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    private function prepararDatosValidacion($datos)
    {
        return [
            "identidad" => Sanitizer::limpiarIdentidad($datos["identidad"] ?? ""),
            "nombre" => Sanitizer::nombreTitulo($datos["nombre"] ?? ""),
            "apellido" => Sanitizer::nombreTitulo($datos["apellido"] ?? ""),
            "edad" => Sanitizer::limpiarEntero($datos["edad"] ?? ""),
            "tipo_sangre_id" => Sanitizer::limpiarSelect($datos["tipo_sangre_id"] ?? 0),
            "sexo_id" => Sanitizer::limpiarSelect($datos["sexo_id"] ?? 0),
            "nacionalidad_id" => Sanitizer::limpiarSelect($datos["nacionalidad_id"] ?? 0),
            "ruta_id" => Sanitizer::limpiarSelect($datos["ruta_id"] ?? 0),
            "correo" => Sanitizer::limpiarCorreo($datos["correo"] ?? ""),
            "celular" => Sanitizer::limpiarCelular($datos["celular"] ?? ""),
            "empleado_activo" => Sanitizer::limpiarActivo($datos["empleado_activo"] ?? 1),
            "motivo_baja" => Sanitizer::limpiarMotivoBaja($datos["motivo_baja"] ?? "")
        ];
    }

    private function convertirABaseDatos($datos)
    {
        $motivoTerminacionId = null;

        if (isset($datos["motivo_terminacion_id"]) && intval($datos["motivo_terminacion_id"]) > 0) {
            $motivoTerminacionId = intval($datos["motivo_terminacion_id"]);
        }

        return [
            "identidad" => $datos["identidad"],
            "Nombre" => $datos["nombre"],
            "Apellido" => $datos["apellido"],
            "Edad" => intval($datos["edad"]),
            "tipo_sangre_id" => intval($datos["tipo_sangre_id"]),
            "sexo_id" => intval($datos["sexo_id"]),
            "nacionalidad_id" => intval($datos["nacionalidad_id"]),
            "ruta_id" => intval($datos["ruta_id"]),
            "Email1" => $datos["correo"],
            "Celular" => $datos["celular"],
            "Empleado_Activo" => intval($datos["empleado_activo"]),
            "motivo_terminacion_id" => $motivoTerminacionId,
            "Motivo_Baja" => $datos["motivo_baja"]
        ];
    }

    private function existeIdentidad($identidad, $idIgnorar = null)
    {
        if ($idIgnorar === null) {
            $sql = "SELECT id FROM datospersonales WHERE identidad = ?";
            $resultado = $this->db->selectOne($sql, [$identidad]);
        } else {
            $sql = "SELECT id FROM datospersonales WHERE identidad = ? AND id != ?";
            $resultado = $this->db->selectOne($sql, [$identidad, $idIgnorar]);
        }

        return $resultado ? true : false;
    }

    private function existeCorreo($correo, $idIgnorar = null)
    {
        if ($idIgnorar === null) {
            $sql = "SELECT id FROM datospersonales WHERE Email1 = ?";
            $resultado = $this->db->selectOne($sql, [$correo]);
        } else {
            $sql = "SELECT id FROM datospersonales WHERE Email1 = ? AND id != ?";
            $resultado = $this->db->selectOne($sql, [$correo, $idIgnorar]);
        }

        return $resultado ? true : false;
    }

    public function guardar($datos)
    {
        $datosLimpios = $this->prepararDatosValidacion($datos);

        $errores = Validator::validarColaborador($datosLimpios);

        if (!empty($errores)) {
            return [
                "success" => false,
                "message" => "Hay errores en los datos del colaborador.",
                "errors" => $errores
            ];
        }

        if ($this->existeIdentidad($datosLimpios["identidad"])) {
            return [
                "success" => false,
                "message" => "La identidad ya está registrada.",
                "errors" => ["Ya existe un colaborador con esa identidad."]
            ];
        }

        if ($this->existeCorreo($datosLimpios["correo"])) {
            return [
                "success" => false,
                "message" => "El correo ya está registrado.",
                "errors" => ["Ya existe un colaborador con ese correo."]
            ];
        }

        $datosBD = $this->convertirABaseDatos($datosLimpios);

        $resultado = $this->db->insertSeguro("datospersonales", $datosBD);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Colaborador guardado correctamente.",
                "errors" => [],
                "id" => $this->db->lastInsertId()
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo guardar el colaborador.",
            "errors" => ["Error al insertar en la base de datos."]
        ];
    }

    public function actualizar($id, $datos)
    {
        $id = intval($id);
        $datosLimpios = $this->prepararDatosValidacion($datos);

        $errores = Validator::validarColaborador($datosLimpios);

        if ($id <= 0) {
            $errores[] = "El ID del colaborador no es válido.";
        }

        if (!empty($errores)) {
            return [
                "success" => false,
                "message" => "Hay errores en los datos del colaborador.",
                "errors" => $errores
            ];
        }

        if ($this->existeIdentidad($datosLimpios["identidad"], $id)) {
            return [
                "success" => false,
                "message" => "La identidad ya pertenece a otro colaborador.",
                "errors" => ["No se puede repetir la identidad."]
            ];
        }

        if ($this->existeCorreo($datosLimpios["correo"], $id)) {
            return [
                "success" => false,
                "message" => "El correo ya pertenece a otro colaborador.",
                "errors" => ["No se puede repetir el correo."]
            ];
        }

        $datosBD = $this->convertirABaseDatos($datosLimpios);

        $resultado = $this->db->updateSeguro("datospersonales", $datosBD, ["id" => $id]);

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Colaborador actualizado correctamente.",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo actualizar el colaborador.",
            "errors" => ["Error al actualizar en la base de datos."]
        ];
    }

    public function listar()
    {
        $sql = "SELECT 
                    d.id,
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
                    d.Empleado_Activo AS empleado_activo,
                    mt.MOTIVO AS motivo_terminacion,
                    d.Motivo_Baja AS motivo_baja,
                    d.fecha_registro
                FROM datospersonales d
                INNER JOIN cat_tiposangre ts ON d.tipo_sangre_id = ts.id
                INNER JOIN cat_sexo sx ON d.sexo_id = sx.id
                INNER JOIN cat_nacionalidades n ON d.nacionalidad_id = n.id
                INNER JOIN cat_rutas r ON d.ruta_id = r.id
                LEFT JOIN cat_motivos_terminacion mt ON d.motivo_terminacion_id = mt.C_TERMINACION
                ORDER BY d.id DESC";

        return $this->db->select($sql);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT 
                    id,
                    identidad,
                    Nombre AS nombre,
                    Apellido AS apellido,
                    Edad AS edad,
                    tipo_sangre_id,
                    sexo_id,
                    nacionalidad_id,
                    ruta_id,
                    Email1 AS correo,
                    Celular AS celular,
                    Empleado_Activo AS empleado_activo,
                    motivo_terminacion_id,
                    Motivo_Baja AS motivo_baja,
                    fecha_registro
                FROM datospersonales
                WHERE id = ?";

        return $this->db->selectOne($sql, [intval($id)]);
    }

    public function darBaja($id, $motivo)
    {
        $id = intval($id);
        $motivo = Sanitizer::limpiarTexto($motivo);

        if ($id <= 0) {
            return [
                "success" => false,
                "message" => "ID no válido.",
                "errors" => ["Debe seleccionar un colaborador válido."]
            ];
        }

        if ($motivo === "") {
            return [
                "success" => false,
                "message" => "Debe escribir el motivo de baja.",
                "errors" => ["El motivo de baja es obligatorio."]
            ];
        }

        $resultado = $this->db->updateSeguro(
            "datospersonales",
            [
                "Empleado_Activo" => 0,
                "Motivo_Baja" => $motivo
            ],
            [
                "id" => $id
            ]
        );

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Colaborador dado de baja correctamente.",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo dar de baja al colaborador.",
            "errors" => ["Error al actualizar el estado."]
        ];
    }

    public function reactivar($id)
    {
        $id = intval($id);

        if ($id <= 0) {
            return [
                "success" => false,
                "message" => "ID no válido.",
                "errors" => ["Debe seleccionar un colaborador válido."]
            ];
        }

        $resultado = $this->db->updateSeguro(
            "datospersonales",
            [
                "Empleado_Activo" => 1,
                "motivo_terminacion_id" => null,
                "Motivo_Baja" => null
            ],
            [
                "id" => $id
            ]
        );

        if ($resultado) {
            return [
                "success" => true,
                "message" => "Colaborador reactivado correctamente.",
                "errors" => []
            ];
        }

        return [
            "success" => false,
            "message" => "No se pudo reactivar al colaborador.",
            "errors" => ["Error al actualizar el estado."]
        ];
    }
}

?>