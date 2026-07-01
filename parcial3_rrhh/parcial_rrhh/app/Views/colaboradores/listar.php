<?php
$colaboradores = $colaboradores ?? [];
$mensaje = $mensaje ?? "";
?>

<div class="card card-custom">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Listado de colaboradores</h4>
        <a href="index.php?accion=crear_colaborador" class="btn btn-light">Nuevo colaborador</a>
    </div>

    <div class="card-body">

        <?php if ($mensaje == "guardado"): ?>
            <div class="alert alert-success alert-custom">Colaborador guardado correctamente.</div>
        <?php elseif ($mensaje == "actualizado"): ?>
            <div class="alert alert-success alert-custom">Colaborador actualizado correctamente.</div>
        <?php elseif ($mensaje == "baja"): ?>
            <div class="alert alert-warning alert-custom">Colaborador dado de baja correctamente.</div>
        <?php elseif ($mensaje == "reactivado"): ?>
            <div class="alert alert-success alert-custom">Colaborador reactivado correctamente.</div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identidad</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Sexo</th>
                        <th>Ruta</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (empty($colaboradores)): ?>
                        <tr>
                            <td colspan="10" class="text-center">No hay colaboradores registrados.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($colaboradores as $colaborador): ?>
                        <tr>
                            <td><?php echo $colaborador["id"]; ?></td>
                            <td><?php echo htmlspecialchars($colaborador["identidad"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($colaborador["nombre"] . " " . $colaborador["apellido"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo $colaborador["edad"]; ?></td>
                            <td><?php echo htmlspecialchars($colaborador["sexo"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($colaborador["ruta"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($colaborador["correo"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td><?php echo htmlspecialchars($colaborador["celular"], ENT_QUOTES, "UTF-8"); ?></td>
                            <td>
                                <?php if ($colaborador["empleado_activo"] == 1): ?>
                                    <span class="badge-activo">Activo</span>
                                <?php else: ?>
                                    <span class="badge-inactivo">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?accion=editar_colaborador&id=<?php echo $colaborador["id"]; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?accion=crear_perfil&colaborador_id=<?php echo $colaborador["id"]; ?>" class="btn btn-primary btn-sm">Perfil</a>

                                <?php if ($colaborador["empleado_activo"] == 1): ?>
                                    <a href="#" onclick="return mostrarMotivoBaja(<?php echo $colaborador["id"]; ?>);" class="btn btn-danger btn-sm">Baja</a>
                                <?php else: ?>
                                    <a href="index.php?accion=reactivar_colaborador&id=<?php echo $colaborador["id"]; ?>" class="btn btn-success btn-sm">Reactivar</a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if (!empty($colaborador["motivo_baja"])): ?>
                            <tr>
                                <td colspan="10" class="table-warning">
                                    <strong>Motivo de baja:</strong>
                                    <?php echo htmlspecialchars($colaborador["motivo_baja"], ENT_QUOTES, "UTF-8"); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>