<?php
$catalogos = $catalogos ?? [];
$datosFormulario = $datosFormulario ?? [];
$errores = $errores ?? [];
$mensajeError = $mensajeError ?? "";
?>

<div class="card card-custom">
    <div class="card-header">
        <h4>Editar colaborador</h4>
    </div>

    <div class="card-body">

        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger alert-custom">
                <strong><?php echo $mensajeError; ?></strong>
                <ul class="mb-0 mt-2">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?accion=actualizar_colaborador" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($datosFormulario["id"] ?? "", ENT_QUOTES, "UTF-8"); ?>">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Identidad</label>
                    <input type="text" name="identidad" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["identidad"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["nombre"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["apellido"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Edad</label>
                    <input type="number" name="edad" class="form-control" min="18" max="75" required
                           value="<?php echo htmlspecialchars($datosFormulario["edad"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Tipo de sangre</label>
                    <select name="tipo_sangre_id" class="form-select" required>
                        <?php foreach (($catalogos["tipos_sangre"] ?? []) as $item): ?>
                            <option value="<?php echo $item["id"]; ?>" <?php echo (($datosFormulario["tipo_sangre_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Sexo</label>
                    <select name="sexo_id" class="form-select" required>
                        <?php foreach (($catalogos["sexos"] ?? []) as $item): ?>
                            <option value="<?php echo $item["id"]; ?>" <?php echo (($datosFormulario["sexo_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Nacionalidad</label>
                    <select name="nacionalidad_id" class="form-select" required>
                        <?php foreach (($catalogos["nacionalidades"] ?? []) as $item): ?>
                            <option value="<?php echo $item["id"]; ?>" <?php echo (($datosFormulario["nacionalidad_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Ruta</label>
                    <select name="ruta_id" class="form-select" required>
                        <?php foreach (($catalogos["rutas"] ?? []) as $item): ?>
                            <option value="<?php echo $item["id"]; ?>" <?php echo (($datosFormulario["ruta_id"] ?? "") == $item["id"]) ? "selected" : ""; ?>>
                                <?php echo htmlspecialchars($item["nombre"], ENT_QUOTES, "UTF-8"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["correo"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Celular</label>
                    <input type="text" name="celular" class="form-control" required
                           value="<?php echo htmlspecialchars($datosFormulario["celular"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Empleado activo</label>
                    <select name="empleado_activo" class="form-select">
                        <option value="1" <?php echo (($datosFormulario["empleado_activo"] ?? "") == 1) ? "selected" : ""; ?>>Activo</option>
                        <option value="0" <?php echo (($datosFormulario["empleado_activo"] ?? "") == 0) ? "selected" : ""; ?>>Inactivo</option>
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Motivo de baja</label>
                    <input type="text" name="motivo_baja" class="form-control"
                           value="<?php echo htmlspecialchars($datosFormulario["motivo_baja"] ?? "", ENT_QUOTES, "UTF-8"); ?>">
                </div>

            </div>

            <button type="submit" class="btn btn-warning">Actualizar colaborador</button>
            <a href="index.php?accion=listar_colaboradores" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>