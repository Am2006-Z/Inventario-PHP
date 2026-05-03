<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-history"></i> Historial de Asignaciones</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=asignacion&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Asignaciones Activas
            </a>
            <a href="?controller=dashboard&action=index" class="btn btn-secondary">
                <i class="fas fa-home"></i> Inicio
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($asignaciones)): ?>
                <div class="alert alert-info">
                    No hay asignaciones devueltas en el historial.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Computador</th>
                                <th>Serial</th>
                                <th>Empleado</th>
                                <th>Departamento</th>
                                <th>Asignado</th>
                                <th>Devuelto</th>
                                <th>Duración</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($asignaciones as $asignacion): 
                                $asignado = new DateTime($asignacion['fecha_asignacion']);
                                $devuelto = new DateTime($asignacion['fecha_devolucion']);
                                $diff = $devuelto->diff($asignado);
                                $duracion = $diff->days . 'd ' . $diff->h . 'h';
                            ?>
                            <tr>
                                <td>
                                    <strong>
                                        <?= htmlspecialchars($asignacion['marca_nombre'] ?? 'N/A') ?> 
                                        <?= htmlspecialchars($asignacion['modelo'] ?? '') ?>
                                    </strong>
                                </td>
                                <td><?= htmlspecialchars($asignacion['serial'] ?? '') ?></td>
                                <td><?= htmlspecialchars($asignacion['empleado_nombre'] ?? '') ?></td>
                                <td><?= htmlspecialchars($asignacion['departamento'] ?? '') ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_devolucion'])) ?></td>
                                <td>
                                    <span class="badge badge-info"><?= $duracion ?></span>
                                </td>
                                <td>
                                    <a href="?controller=asignacion&action=view&id=<?= $asignacion['id'] ?>" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
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
