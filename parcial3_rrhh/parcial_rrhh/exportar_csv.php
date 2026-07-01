<?php

require_once __DIR__ . "/app/Models/PerfilLaboral.php";

$modelo = new PerfilLaboral();
$registros = $modelo->reporteGeneral();

$nombreArchivo = "reporte_rrhh_itech.csv";

header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");

$salida = fopen("php://output", "w");

fputcsv($salida, [
    "ID",
    "Identidad",
    "Nombre",
    "Apellido",
    "Edad",
    "Tipo Sangre",
    "Sexo",
    "Nacionalidad",
    "Ruta",
    "Correo",
    "Celular",
    "Estado Empleado",
    "Motivo Terminación",
    "Motivo Baja",
    "Ocupación",
    "Tipo Empleado",
    "Planilla",
    "Salario",
    "Fecha Inicio",
    "Fecha Fin",
    "Estado Cargo",
    "Firma Integridad"
]);

foreach ($registros as $fila) {
    fputcsv($salida, [
        $fila["colaborador_id"] ?? "",
        $fila["identidad"] ?? "",
        $fila["nombre"] ?? "",
        $fila["apellido"] ?? "",
        $fila["edad"] ?? "",
        $fila["tipo_sangre"] ?? "",
        $fila["sexo"] ?? "",
        $fila["nacionalidad"] ?? "",
        $fila["ruta"] ?? "",
        $fila["correo"] ?? "",
        $fila["celular"] ?? "",
        $fila["estado_empleado"] ?? "",
        $fila["motivo_terminacion"] ?? "",
        $fila["motivo_baja"] ?? "",
        $fila["ocupacion"] ?? "",
        $fila["tipo_empleado"] ?? "",
        $fila["planilla"] ?? "",
        $fila["salario"] ?? "",
        $fila["fecha_inicio"] ?? "",
        $fila["fecha_fin"] ?? "",
        $fila["estado_cargo"] ?? "",
        $fila["firma_integridad"] ?? ""
    ]);
}

fclose($salida);
exit;

?>