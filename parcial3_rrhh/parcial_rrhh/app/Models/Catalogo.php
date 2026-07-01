<?php

require_once __DIR__ . "/../Config/Database.php";

class Catalogo
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function obtenerTiposSangre()
    {
        return $this->db->select("
            SELECT id, TRIM(Nombre) AS nombre
            FROM cat_tiposangre
            ORDER BY Nombre ASC
        ");
    }

    public function obtenerSexos()
    {
        return $this->db->select("
            SELECT id, nombre
            FROM cat_sexo
            ORDER BY nombre ASC
        ");
    }

    public function obtenerNacionalidades()
    {
        return $this->db->select("
            SELECT id, nombre
            FROM cat_nacionalidades
            ORDER BY nombre ASC
        ");
    }

    public function obtenerRutas()
    {
        return $this->db->select("
            SELECT id, Nombre AS nombre
            FROM cat_rutas
            ORDER BY Nombre ASC
        ");
    }

    public function obtenerTiposEmpleado()
    {
        return $this->db->select("
            SELECT id, Nombre AS nombre, Abreviatura
            FROM cat_tipoempleado
            WHERE Activo = 1
            ORDER BY Nombre ASC
        ");
    }

    public function obtenerPlanillas()
    {
        return $this->db->select("
            SELECT id, nombre
            FROM cat_tipos_planilla
            WHERE activo = 1
            ORDER BY nombre ASC
        ");
    }

    public function obtenerOcupaciones()
    {
        return $this->db->select("
            SELECT C_OCUP AS id, OCUPACION AS nombre
            FROM cat_ocupaciones
            WHERE Activo = 1
            ORDER BY OCUPACION ASC
        ");
    }

    public function obtenerMotivosTerminacion()
    {
        return $this->db->select("
            SELECT C_TERMINACION AS id, MOTIVO AS nombre
            FROM cat_motivos_terminacion
            ORDER BY MOTIVO ASC
        ");
    }

    public function obtenerTodos()
    {
        return [
            "tipos_sangre" => $this->obtenerTiposSangre(),
            "sexos" => $this->obtenerSexos(),
            "nacionalidades" => $this->obtenerNacionalidades(),
            "rutas" => $this->obtenerRutas(),
            "tipos_empleado" => $this->obtenerTiposEmpleado(),
            "planillas" => $this->obtenerPlanillas(),
            "ocupaciones" => $this->obtenerOcupaciones(),
            "motivos_terminacion" => $this->obtenerMotivosTerminacion()
        ];
    }
}

?>