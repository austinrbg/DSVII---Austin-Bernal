<?php

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/app/Models/PerfilLaboral.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$modelo = new PerfilLaboral();
$registros = $modelo->reporteGeneral();

$documento = new Spreadsheet();

$documento->getProperties()
    ->setCreator("iTECH Contrataciones")
    ->setLastModifiedBy("iTECH Contrataciones")
    ->setTitle("Reporte general de colaboradores")
    ->setDescription("Reporte exportado desde el sistema RRHH");

$hoja = $documento->getActiveSheet();
$hoja->setTitle("Reporte RRHH");

$encabezados = [
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
];

$hoja->fromArray($encabezados, null, "A1");

$filaExcel = 2;

foreach ($registros as $fila) {
    $hoja->setCellValue("A" . $filaExcel, $fila["colaborador_id"] ?? "");
    $hoja->setCellValue("B" . $filaExcel, $fila["identidad"] ?? "");
    $hoja->setCellValue("C" . $filaExcel, $fila["nombre"] ?? "");
    $hoja->setCellValue("D" . $filaExcel, $fila["apellido"] ?? "");
    $hoja->setCellValue("E" . $filaExcel, $fila["edad"] ?? "");
    $hoja->setCellValue("F" . $filaExcel, $fila["tipo_sangre"] ?? "");
    $hoja->setCellValue("G" . $filaExcel, $fila["sexo"] ?? "");
    $hoja->setCellValue("H" . $filaExcel, $fila["nacionalidad"] ?? "");
    $hoja->setCellValue("I" . $filaExcel, $fila["ruta"] ?? "");
    $hoja->setCellValue("J" . $filaExcel, $fila["correo"] ?? "");
    $hoja->setCellValue("K" . $filaExcel, $fila["celular"] ?? "");
    $hoja->setCellValue("L" . $filaExcel, $fila["estado_empleado"] ?? "");
    $hoja->setCellValue("M" . $filaExcel, $fila["motivo_terminacion"] ?? "");
    $hoja->setCellValue("N" . $filaExcel, $fila["motivo_baja"] ?? "");
    $hoja->setCellValue("O" . $filaExcel, $fila["ocupacion"] ?? "");
    $hoja->setCellValue("P" . $filaExcel, $fila["tipo_empleado"] ?? "");
    $hoja->setCellValue("Q" . $filaExcel, $fila["planilla"] ?? "");
    $hoja->setCellValue("R" . $filaExcel, $fila["salario"] ?? "");
    $hoja->setCellValue("S" . $filaExcel, $fila["fecha_inicio"] ?? "");
    $hoja->setCellValue("T" . $filaExcel, $fila["fecha_fin"] ?? "");
    $hoja->setCellValue("U" . $filaExcel, $fila["estado_cargo"] ?? "");
    $hoja->setCellValue("V" . $filaExcel, $fila["firma_integridad"] ?? "");

    $filaExcel++;
}

foreach (range("A", "V") as $columna) {
    $hoja->getColumnDimension($columna)->setAutoSize(true);
}

$writer = new Xlsx($documento);

$nombreArchivo = "reporte_rrhh_itech.xlsx";

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
header("Cache-Control: max-age=0");

$writer->save("php://output");
exit;

?>