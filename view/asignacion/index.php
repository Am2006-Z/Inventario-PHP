<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-tasks"></i> Asignaciones Activas</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=dashboard&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="?controller=asignacion&action=create" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Asignación
            </a>
            <a href="?controller=asignacion&action=historial" class="btn btn-info">
                <i class="fas fa-history"></i> Historial
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($asignaciones)): ?>
                <div class="alert alert-info">
                    No hay asignaciones activas. <a href="?controller=asignacion&action=create">Crear una</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Computador</th>
                                <th>Serial</th>
                                <th>Empleado</th>
                                <th>Departamento</th>
                                <th>Fecha Asignación</th>
                                <th>Días Asignado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $asignacion): 
                                $fechaAsignacion = new DateTime($asignacion['fecha_asignacion']);
                                $ahora = new DateTime();
                                $diasAsignado = $ahora->diff($fechaAsignacion)->days;
                            ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= htmlspecialchars($asignacion['marca_nombre'] ?? 'N/A') ?> 
                                        <?= htmlspecialchars($asignacion['modelo'] ?? '') ?>
                                    </strong>
                                </td>
                                <td><?= htmlspecialchars($asignacion['serial'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asignacion['empleado_nombre'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asignacion['departamento'] ?? '') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?></td>
                                <td>
                                    <span class="badge badge-info"><?= $diasAsignado ?> días</span>
                                </td>
                                <td>
                                    <a href="?controller=asignacion&action=view&id=<?= $asignacion['id'] ?>" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="?controller=asignacion&action=devolver&id=<?= $asignacion['id'] ?>" 
                                       class="btn btn-sm btn-warning" title="Devolver">
                                        <i class="fas fa-reply"></i> Devolver
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
