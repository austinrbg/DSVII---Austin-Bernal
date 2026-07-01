<?php
$catalogos = $catalogos ?? [
    "ocupaciones" => [],
    "tipos_empleado" => [],
    "planillas" => []
];

$colaboradores = $colaboradores ?? [];
$perfiles = $perfiles ?? [];
$datosFormulario = $datosFormulario ?? [];
$errores = $errores ?? [];
$mensaje = $mensaje ?? "";
$mensajeError = $mensajeError ?? "";
$integridades = $integridades ?? [];
?>

<div class="card card-custom">
    <div class="card-header">
        <h4>Registrar perfil laboral</h4>
    </div>

    <div class="card-body">

        <?php if ($mensaje == "perfil_guardado"): ?>
            <div class="alert alert-success alert-custom">
                Perfil laboral guardado correctamente. Se generó la firma de integridad.
            </div>
        <?php elseif ($mensaje == "perfil_actualizado"): ?>
            <div class="alert alert-success alert-custom">
                Perfil laboral actualizado correctamente. Se regeneró la firma de integridad.
            </div>
        <?php elseif ($mensaje == "perfil_no_encontrado"): ?>
            <div class="alert alert-danger alert-custom">
                El perfil laboral no fue encontrado.
            </div>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger alert-custom">
                <strong><?php echo htmlspecialchars($mensajeError ?? "Corrige los siguientes errores:", ENT_QUOTES, "UTF-8"); ?></strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=guardar_perfil" method="POST">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Colaborador</label>
                    <select name="colaborador_id" class="form-select" required>
                        <option value="">Seleccione un colaborador</option>

                        <?php foreach ($colaboradores as $colaborador): ?>
                            <option value="<?php echo $colaborador["id"]; ?>"
                                <?php echo (($datosFormulario["colaborador_id"] ?? "") == $colaborador["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars(
                                    $colaborador["identidad"] . " - " . $colaborador["nombre"] . " " . $colaborador["apellido"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Puesto u ocupación</label>
                    <select name="ocupacion_id" class="form-select" required>
                        <option value="">Seleccione una ocupación</option>

                        <?php foreach ($catalogos["ocupaciones"] as $item): ?>
                            <option value="<?php echo $item["id"]; ?>"
                                <?php echo (($datosFormulario["ocupacion_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de empleado</label>
                    <select name="tipo_empleado_id" class="form-select" required>
                        <option value="">Seleccione</option>

                        <?php foreach ($catalogos["tipos_empleado"] as $item): ?>
                            <option value="<?php echo $item["id"]; ?>"
                                <?php echo (($datosFormulario["tipo_empleado_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Planilla</label>
                    <select name="planilla_id" class="form-select" required>
                        <option value="">Seleccione</option>

                        <?php foreach ($catalogos["planillas"] as $item): ?>
                            <option value="<?php echo $item["id"]; ?>"
                                <?php echo (($datosFormulario["planilla_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Salario</label>
                    <input type="number" step="0.01" min="0" name="salario" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["salario"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["fecha_inicio"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de fin</label>
                    <input type="date" name="fecha_fin" class="form-control"
                           value="<?php echo htmlspecialchars($datosFormulario["fecha_fin"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Cargo activo</label>
                    <select name="cargo_activo" class="form-select">
                        <option value="1" <?php echo (($datosFormulario["cargo_activo"] ?? "1") == "1") ? "selected" : ""; ?>>
                            Activo
                        </option>
                        <option value="0" <?php echo (($datosFormulario["cargo_activo"] ?? "") == "0") ? "selected" : ""; ?>>
                            Inactivo
                        </option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Guardar perfil laboral</button>
                <a href="index.php?accion=listar_colaboradores" class="btn btn-secondary">Volver a colaboradores</a>
            </div>

        </form>
    </div>
</div>

<div class="card card-custom">
    <div class="card-header">
        <h4>Historial laboral registrado</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Colaborador</th>
                        <th>Identidad</th>
                        <th>Ocupación</th>
                        <th>Tipo</th>
                        <th>Planilla</th>
                        <th>Salario</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Cargo</th>
                        <th>Integridad</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($perfiles)): ?>
                        <tr>
                            <td colspan="12" class="text-center">
                                No hay perfiles laborales registrados.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($perfiles as $perfil): ?>
                        <tr>
                            <td><?php echo $perfil["id"]; ?></td>
                            <td><?php echo htmlspecialchars($perfil["colaborador"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($perfil["identidad"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($perfil["ocupacion"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($perfil["tipo_empleado"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($perfil["planilla"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td>B/. <?php echo number_format((float)$perfil["salario"], 2); ?></td>
                            <td><?php echo htmlspecialchars($perfil["fecha_inicio"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($perfil["fecha_fin"] ?? "Actual", ENT_QUOTES, "UTF-8"); ?></td>
                            <td>
                                <?php if ($perfil["cargo_activo"] == 1): ?>
                                    <span class="badge-activo">Activo</span>
                                <?php else: ?>
                                    <span class="badge-inactivo">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $estadoIntegridad = $integridades[$perfil["id"]]["integridad"] ?? "NO_VERIFICADO";
                                ?>

                                <?php if ($estadoIntegridad == "VALIDO"): ?>
                                    <span class="badge-integridad">Válido</span>
                                <?php else: ?>
                                    <span class="badge-inactivo">Alterado</span>
                                <?php endif; ?>

                                <br>

                                <small>
                                    <?php echo substr($perfil["firma_integridad"], 0, 12); ?>...
                                </small>
                            </td>
                            <td>
                                <a href="index.php?accion=editar_perfil&id=<?php echo $perfil["id"]; ?>" class="btn btn-warning btn-sm">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p class="text-muted mt-3">
            La firma de integridad permite verificar si los datos sensibles del perfil laboral fueron modificados directamente en la base de datos.
        </p>
    </div>
</div>