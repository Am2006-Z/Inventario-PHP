<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-chart-pie"></i> Dashboard - Inventario de Computadores</h2>
        </div>
        <div class="col-md-4 text-right">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-info" title="Tu perfil">
                    <i class="fas fa-user-circle"></i> <?= htmlspecialchars($usuario) ?> (<?= strtoupper(htmlspecialchars($rol)) ?>)
                </button>
                <a href="?controller=auth&action=logout" class="btn btn-sm btn-danger">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Computadores</h5>
                    <p class="card-text"><strong><?= $estadisticas['total'] ?? 0 ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Disponibles</h5>
                    <p class="card-text"><strong><?= $estadisticas['disponibles'] ?? 0 ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Asignados</h5>
                    <p class="card-text"><strong><?= $estadisticas['asignados'] ?? 0 ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Mantenimiento</h5>
                    <p class="card-text"><strong><?= $estadisticas['mantenimiento'] ?? 0 ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menú de Acciones según Rol -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5>Acciones Disponibles:</h5>
            <div class="btn-group" role="group">
                <a href="?controller=computador&action=index" class="btn btn-info">
                    <i class="fas fa-desktop"></i> Ver Computadores
                </a>
                
                <?php if (in_array($rol, ['admin', 'empleado'])): ?>
                    <a href="?controller=computador&action=create" class="btn btn-success">
                        <i class="fas fa-plus"></i> Crear Computador
                    </a>
                    <a href="?controller=asignacion&action=index" class="btn btn-warning">
                        <i class="fas fa-tasks"></i> Asignaciones
                    </a>
                    <a href="?controller=asignacion&action=create" class="btn btn-primary">
                        <i class="fas fa-link"></i> Nueva Asignación
                    </a>
                <?php endif; ?>

                <?php if ($rol === 'admin'): ?>
                    <a href="?controller=usuario&action=index" class="btn btn-secondary">
                        <i class="fas fa-users"></i> Gestionar Usuarios
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Asignaciones Activas -->
    <?php if (in_array($rol, ['admin', 'empleado']) && !empty($asignacionesActivas)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Asignaciones Activas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Computador</th>
                                    <th>Empleado</th>
                                    <th>Departamento</th>
                                    <th>Fecha Asignación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asignacionesActivas as $asignacion): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($asignacion['marca_nombre'] ?? 'N/A') ?> 
                                        <?= htmlspecialchars($asignacion['modelo'] ?? '') ?>
                                    </td>
                                    <td><?= htmlspecialchars($asignacion['empleado_nombre'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($asignacion['departamento'] ?? '') ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?></td>
                                    <td>
                                        <a href="?controller=asignacion&action=view&id=<?= $asignacion['id'] ?>" 
                                           class="btn btn-sm btn-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?controller=asignacion&action=devolver&id=<?= $asignacion['id'] ?>" 
                                           class="btn btn-sm btn-warning" title="Devolver">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
