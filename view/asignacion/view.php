<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-info-circle"></i> Detalle de Asignación</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=asignacion&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-laptop"></i> 
                        <?= htmlspecialchars($asignacion['marca_nombre'] ?? 'N/A') ?> 
                        <?= htmlspecialchars($asignacion['modelo'] ?? '') ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Serial del Computador</h6>
                            <p class="lead"><?= htmlspecialchars($asignacion['serial'] ?? '') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Estado de Asignación</h6>
                            <p class="lead">
                                <?php if ($asignacion['fecha_devolucion']): ?>
                                    <span class="badge badge-secondary p-2">DEVUELTO</span>
                                <?php else: ?>
                                    <span class="badge badge-success p-2">ACTIVO</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="text-muted mb-2"><i class="fas fa-user"></i> Información del Receptor</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td><?= htmlspecialchars($asignacion['empleado_nombre'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Departamento:</strong></td>
                            <td><?= htmlspecialchars($asignacion['departamento'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Usuario del Sistema:</strong></td>
                            <td><?= htmlspecialchars($asignacion['usuario_nombre'] ?? 'Sin usuario') ?></td>
                        </tr>
                    </table>

                    <hr>

                    <h6 class="text-muted mb-2"><i class="fas fa-calendar"></i> Fechas</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Fecha de Asignación:</strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?></td>
                        </tr>
                        <?php if ($asignacion['fecha_devolucion']): ?>
                        <tr>
                            <td><strong>Fecha de Devolución:</strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_devolucion'])) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Duración:</strong></td>
                            <td>
                                <?php 
                                    $asignado = new DateTime($asignacion['fecha_asignacion']);
                                    $devuelto = new DateTime($asignacion['fecha_devolucion']);
                                    $diff = $devuelto->diff($asignado);
                                    echo $diff->days . ' días, ' . $diff->h . ' horas';
                                ?>
                            </td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td><strong>Tiempo Actual:</strong></td>
                            <td>
                                <?php 
                                    $asignado = new DateTime($asignacion['fecha_asignacion']);
                                    $ahora = new DateTime();
                                    $diff = $ahora->diff($asignado);
                                    echo $diff->days . ' días, ' . $diff->h . ' horas';
                                ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </table>

                    <?php if (!empty($asignacion['observaciones'])): ?>
                    <hr>
                    <h6 class="text-muted mb-2"><i class="fas fa-sticky-note"></i> Observaciones</h6>
                    <p><?= nl2br(htmlspecialchars($asignacion['observaciones'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Acciones</h5>
                </div>
                <div class="card-body">
                    <?php if (!$asignacion['fecha_devolucion']): ?>
                    <a href="?controller=asignacion&action=devolver&id=<?= $asignacion['id'] ?>" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-reply"></i> Devolver Computador
                    </a>
                    <?php else: ?>
                    <div class="alert alert-success">
                        <strong>Asignación completada</strong><br>
                        Este equipo ya fue devuelto.
                    </div>
                    <?php endif; ?>
                    
                    <a href="?controller=asignacion&action=index" class="btn btn-secondary btn-block">
                        <i class="fas fa-list"></i> Ver Asignaciones
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
