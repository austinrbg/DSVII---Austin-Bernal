<?php

require_once __DIR__ . "/app/Models/PerfilLaboral.php";

$modelo = new PerfilLaboral();

$datos = [
    "colaborador_id" => "1",
    "ocupacion_id" => "15",
    "tipo_empleado_id" => "4",
    "planilla_id" => "2",
    "salario" => "1200.50",
    "fecha_inicio" => "2026-07-01",
    "fecha_fin" => "",
    "cargo_activo" => "1"
];

$respuesta = $modelo->guardar($datos);

echo "<h3>Resultado de guardar perfil laboral</h3>";
echo "<pre>";
print_r($respuesta);
echo "</pre>";

echo "<h3>Listado de perfiles laborales</h3>";
echo "<pre>";
print_r($modelo->listar());
echo "</pre>";

if (!empty($respuesta["id"])) {
    echo "<h3>Verificación de integridad</h3>";
    echo "<pre>";
    print_r($modelo->verificarIntegridad($respuesta["id"]));
    echo "</pre>";
}

?>