<?php
$catalogos = $catalogos ?? [];
$colaboradores = $colaboradores ?? [];
$datosFormulario = $datosFormulario ?? [];
$errores = $errores ?? [];
$mensajeError = $mensajeError ?? "";
?>

<div class="card card-custom">
    <div class="card-header">
        <h4>Editar perfil laboral</h4>
    </div>

    <div class="card-body">

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger alert-custom">
                <strong><?php echo htmlspecialchars($mensajeError, ENT_QUOTES, "UTF-8"); ?></strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=actualizar_perfil" method="POST">

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($datosFormulario["id"] ?? "", ENT_QUOTES, "UTF-8"); ?>">

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

                        <?php foreach (($catalogos["ocupaciones"] ?? []) as $item): ?>
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

                        <?php foreach (($catalogos["tipos_empleado"] ?? []) as $item): ?>
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

                        <?php foreach (($catalogos["planillas"] ?? []) as $item): ?>
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
                        <option value="1" <?php echo (($datosFormulario["cargo_activo"] ?? "") == 1) ? "selected" : ""; ?>>
                            Activo
                        </option>
                        <option value="0" <?php echo (($datosFormulario["cargo_activo"] ?? "") == 0) ? "selected" : ""; ?>>
                            Inactivo
                        </option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-warning">Actualizar perfil laboral</button>
            <a href="index.php?accion=crear_perfil" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>