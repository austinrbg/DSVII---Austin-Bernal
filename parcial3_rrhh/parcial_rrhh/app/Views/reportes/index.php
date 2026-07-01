<?php
$registros = $registros ?? [];
$integridades = $integridades ?? [];
?>

<div class="card card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Reporte general de colaboradores</h4>

        <div class="d-flex gap-2">
            <a href="exportar_excel.php" class="btn btn-success">
                Exportar Excel
            </a>

            <a href="exportar_csv.php" class="btn btn-warning">
                Exportar CSV
            </a>
        </div>
    </div>

    <div class="card-body">

        <p class="text-muted">
            Reporte general con datos personales, perfil laboral, estado del cargo y verificación visual de integridad.
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identidad</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Nacionalidad</th>
                        <th>Ruta</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Estado empleado</th>
                        <th>Motivo baja</th>
                        <th>Ocupación</th>
                        <th>Tipo empleado</th>
                        <th>Planilla</th>
                        <th>Salario</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado cargo</th>
                        <th>Integridad</th>
                        <th>Firma</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($registros)): ?>
                        <tr>
                            <td colspan="20" class="text-center">
                                No hay datos para mostrar.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($registros as $fila): ?>
                        <?php
                            $perfilId = $fila["perfil_id"] ?? null;
                            $estadoIntegridad = "SIN PERFIL";

                            if (!empty($perfilId)) {
                                $estadoIntegridad = $integridades[$perfilId]["integridad"] ?? "NO_VERIFICADO";
                            }
                        ?>

                        <tr>
                            <td><?php echo htmlspecialchars($fila["colaborador_id"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["identidad"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td>
                                <?php echo htmlspecialchars(($fila["nombre"] ?? "") . " " . ($fila["apellido"] ?? ""), ENT_QUOTES, "UTF-8"); ?>
                            </td>

                            <td><?php echo htmlspecialchars($fila["edad"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["sexo"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["nacionalidad"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["ruta"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["correo"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["celular"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td>
                                <?php if (($fila["estado_empleado"] ?? "") == "Activo"): ?>
                                    <span class="badge-activo">Activo</span>
                                <?php else: ?>
                                    <span class="badge-inactivo">Inactivo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($fila["motivo_baja"] ?? "", ENT_QUOTES, "UTF-8"); ?>
                            </td>

                            <td><?php echo htmlspecialchars($fila["ocupacion"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["tipo_empleado"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["planilla"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td>
                                <?php if (!empty($fila["salario"])): ?>
                                    B/. <?php echo number_format((float)$fila["salario"], 2); ?>
                                <?php endif; ?>
                            </td>

                            <td><?php echo htmlspecialchars($fila["fecha_inicio"] ?? "", ENT_QUOTES, "UTF-8"); ?></td>

                            <td><?php echo htmlspecialchars($fila["fecha_fin"] ?? "Actual", ENT_QUOTES, "UTF-8"); ?></td>

                            <td>
                                <?php if (($fila["estado_cargo"] ?? "") == "Activo"): ?>
                                    <span class="badge-activo">Activo</span>
                                <?php elseif (($fila["estado_cargo"] ?? "") == "Inactivo"): ?>
                                    <span class="badge-inactivo">Inactivo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Sin cargo</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($estadoIntegridad == "VALIDO"): ?>
                                    <span class="badge-activo">Válido</span>
                                <?php elseif ($estadoIntegridad == "ALTERADO"): ?>
                                    <span class="badge-inactivo">Alterado</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Sin verificar</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <small>
                                    <?php echo htmlspecialchars(substr($fila["firma_integridad"] ?? "", 0, 14), ENT_QUOTES, "UTF-8"); ?>...
                                </small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="alert alert-info alert-custom mt-3">
            <strong>Auditoría de integridad:</strong>
            los registros válidos se muestran en verde. Si alguien modifica salario, ocupación, planilla,
            tipo de empleado o fechas directamente en la base de datos, la firma no coincidirá y aparecerá en rojo como alterado.
        </div>

    </div>
</div>