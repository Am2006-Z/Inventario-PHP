<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-info-circle"></i> Detalles del Computador</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=computador&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <?php if (in_array($rol, ['admin', 'empleado'])): ?>
            <a href="?controller=computador&action=edit&id=<?= $computador['id'] ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-laptop"></i> 
                        <?= htmlspecialchars($computador['marca_nombre'] ?? 'N/A') ?> 
                        <?= htmlspecialchars($computador['modelo']) ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Serial</h6>
                            <p class="lead"><?= htmlspecialchars($computador['serial']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Estado</h6>
                            <p class="lead">
                                <?php 
                                    $badgeClass = match($computador['estado']) {
                                        'disponible' => 'badge-success',
                                        'asignado' => 'badge-warning',
                                        'mantenimiento' => 'badge-danger',
                                        'fuera_uso' => 'badge-secondary',
                                        default => 'badge-info'
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> p-2">
                                    <?= ucfirst(str_replace('_', ' ', $computador['estado'])) ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-microchip"></i> Especificaciones</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Marca:</strong></td>
                                    <td><?= htmlspecialchars($computador['marca_nombre'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Categoría:</strong></td>
                                    <td><?= htmlspecialchars($computador['categoria_nombre'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Procesador:</strong></td>
                                    <td><?= htmlspecialchars($computador['procesador'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>RAM:</strong></td>
                                    <td><?= htmlspecialchars($computador['ram'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Almacenamiento:</strong></td>
                                    <td><?= htmlspecialchars($computador['almacenamiento'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <td><strong>S.O.:</strong></td>
                                    <td><?= htmlspecialchars($computador['so'] ?? 'N/A') ?></td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted mb-2"><i class="fas fa-calendar"></i> Información Administrativa</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Fecha Adquisición:</strong></td>
                                    <td><?= $computador['fecha_adquisicion'] ? date('d/m/Y', strtotime($computador['fecha_adquisicion'])) : 'N/A' ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Costo:</strong></td>
                                    <td><?= $computador['costo'] ? '$ ' . number_format($computador['costo'], 2, ',', '.') : 'N/A' ?> COP</td>
                                </tr>
                                <tr>
                                    <td><strong>Registrado:</strong></td>
                                    <td><?= date('d/m/Y H:i', strtotime($computador['fecha_creacion'])) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php if (!empty($computador['descripcion'])): ?>
                    <hr>
                    <div>
                        <h6 class="text-muted mb-2"><i class="fas fa-sticky-note"></i> Descripción</h6>
                        <p><?= nl2br(htmlspecialchars($computador['descripcion'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Acciones</h5>
                </div>
                <div class="card-body">
                    <?php if ($computador['estado'] === 'disponible' && in_array($rol, ['admin', 'empleado'])): ?>
                    <a href="?controller=asignacion&action=create" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-link"></i> Asignar Computador
                    </a>
                    <?php endif; ?>

                    <?php if ($computador['estado'] === 'asignado' && in_array($rol, ['admin', 'empleado'])): ?>
                    <div class="alert alert-warning">
                        <strong>Este equipo está asignado.</strong> Ver historial de asignaciones abajo.
                    </div>
                    <?php endif; ?>

                    <?php if (in_array($rol, ['admin', 'empleado'])): ?>
                    <a href="?controller=computador&action=edit&id=<?= $computador['id'] ?>" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <?php endif; ?>

                    <?php if ($rol === 'admin'): ?>
                    <a href="?controller=computador&action=delete&id=<?= $computador['id'] ?>" 
                       class="btn btn-danger btn-block"
                       onclick="return confirm('¿Eliminar este computador?')">
                        <i class="fas fa-trash"></i> Eliminar
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($asignaciones)): ?>
            <div class="card">
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Historial de Asignaciones</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($asignaciones as $asignacion): ?>
                    <div class="mb-3 pb-2" style="border-bottom: 1px solid #ddd;">
                        <strong><?= htmlspecialchars($asignacion['empleado_nombre'] ?? 'N/A') ?></strong><br>
                        <small class="text-muted">
                            <?= htmlspecialchars($asignacion['departamento'] ?? 'N/A') ?><br>
                            Asignado: <?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?>
                        </small>
                        <?php if ($asignacion['fecha_devolucion']): ?>
                        <small class="text-muted">
                            <br>Devuelto: <?= date('d/m/Y H:i', strtotime($asignacion['fecha_devolucion'])) ?>
                        </small>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
