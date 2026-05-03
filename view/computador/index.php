<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-laptop"></i> Inventario de Computadores</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=dashboard&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <?php if (in_array($rol, ['admin', 'empleado'])): ?>
            <a href="?controller=computador&action=create" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Computador
            </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($computadores)): ?>
                <div class="alert alert-info">
                    No hay computadores registrados. <a href="?controller=computador&action=create">Crear uno</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Serial</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Procesador</th>
                                <th>RAM</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($computadores as $computador): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($computador['serial']) ?></strong></td>
                                <td><?= htmlspecialchars($computador['marca_nombre'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($computador['modelo']) ?></td>
                                <td><?= htmlspecialchars($computador['categoria_nombre'] ?? 'N/A') ?></td>
                                <td>
                                    <?php 
                                        $badgeClass = match($computador['estado']) {
                                            'disponible' => 'badge-success',
                                            'asignado' => 'badge-warning',
                                            'mantenimiento' => 'badge-danger',
                                            'fuera_uso' => 'badge-secondary',
                                            default => 'badge-info'
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= ucfirst(str_replace('_', ' ', $computador['estado'])) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($computador['procesador'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($computador['ram'] ?? 'N/A') ?></td>
                                <td>
                                    <a href="?controller=computador&action=view&id=<?= $computador['id'] ?>" 
                                       class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if (in_array($rol, ['admin', 'empleado'])): ?>
                                    <a href="?controller=computador&action=edit&id=<?= $computador['id'] ?>" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($rol === 'admin'): ?>
                                    <a href="?controller=computador&action=delete&id=<?= $computador['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('¿Estás seguro de eliminar este computador?')"
                                       title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <?php endif; ?>
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
