<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-edit"></i> Editar Computador</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=computador&action=view&id=<?= $computador['id'] ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="serial">Serial</label>
                                <input type="text" class="form-control" id="serial" 
                                       value="<?= htmlspecialchars($computador['serial']) ?>" disabled>
                                <small class="form-text text-muted">No se puede modificar</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="modelo">Modelo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modelo" name="modelo" 
                                       value="<?= htmlspecialchars($computador['modelo']) ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="marca_id">Marca <span class="text-danger">*</span></label>
                                <select class="form-control" id="marca_id" name="marca_id" required>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['id'] ?>" 
                                                <?= $marca['id'] == $computador['marca_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($marca['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                                <select class="form-control" id="categoria_id" name="categoria_id" required>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>" 
                                                <?= $categoria['id'] == $computador['categoria_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="procesador">Procesador</label>
                                <input type="text" class="form-control" id="procesador" name="procesador" 
                                       value="<?= htmlspecialchars($computador['procesador'] ?? '') ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ram">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram" 
                                       value="<?= htmlspecialchars($computador['ram'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="almacenamiento">Almacenamiento</label>
                                <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" 
                                       value="<?= htmlspecialchars($computador['almacenamiento'] ?? '') ?>">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="so">Sistema Operativo</label>
                                <input type="text" class="form-control" id="so" name="so" 
                                       value="<?= htmlspecialchars($computador['so'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="disponible" <?= $computador['estado'] === 'disponible' ? 'selected' : '' ?>>
                                        Disponible
                                    </option>
                                    <option value="asignado" <?= $computador['estado'] === 'asignado' ? 'selected' : '' ?>>
                                        Asignado
                                    </option>
                                    <option value="mantenimiento" <?= $computador['estado'] === 'mantenimiento' ? 'selected' : '' ?>>
                                        Mantenimiento
                                    </option>
                                    <option value="fuera_uso" <?= $computador['estado'] === 'fuera_uso' ? 'selected' : '' ?>>
                                        Fuera de Uso
                                    </option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion" 
                                       value="<?= $computador['fecha_adquisicion'] ?? '' ?>">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="costo">Costo (COP)</label>
                            <input type="number" class="form-control" id="costo" name="costo" step="0.01"
                                   value="<?= $computador['costo'] ?? '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3">
<?= htmlspecialchars($computador['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Actualizar Computador
                            </button>
                            <a href="?controller=computador&action=view&id=<?= $computador['id'] ?>" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-laptop"></i> Información Actual</h5>
                </div>
                <div class="card-body">
                    <p><strong>Serial:</strong> <?= htmlspecialchars($computador['serial']) ?></p>
                    <p><strong>Marca:</strong> <?= htmlspecialchars($computador['marca_nombre'] ?? 'N/A') ?></p>
                    <p><strong>Estado:</strong> 
                        <span class="badge badge-light">
                            <?= ucfirst(str_replace('_', ' ', $computador['estado'])) ?>
                        </span>
                    </p>
                    <p><strong>Registrado:</strong> <?= date('d/m/Y H:i', strtotime($computador['fecha_creacion'])) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
