<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-plus-circle"></i> Registrar Nuevo Computador</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=computador&action=index" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= htmlspecialchars($error) ?>
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="serial">Serial <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="serial" name="serial" required>
                                <small class="form-text text-muted">Identificador único del equipo</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="modelo">Modelo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="modelo" name="modelo" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="marca_id">Marca <span class="text-danger">*</span></label>
                                <select class="form-control" id="marca_id" name="marca_id" required>
                                    <option value="">-- Selecciona una marca --</option>
                                    <?php foreach ($marcas as $marca): ?>
                                        <option value="<?= $marca['id'] ?>">
                                            <?= htmlspecialchars($marca['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                                <select class="form-control" id="categoria_id" name="categoria_id" required>
                                    <option value="">-- Selecciona una categoría --</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>">
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
                                       placeholder="ej: Intel Core i7">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ram">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram" 
                                       placeholder="ej: 16GB DDR4">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="almacenamiento">Almacenamiento</label>
                                <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" 
                                       placeholder="ej: 512GB SSD">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="so">Sistema Operativo</label>
                                <input type="text" class="form-control" id="so" name="so" 
                                       placeholder="ej: Windows 10 Pro">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fecha_adquisicion">Fecha de Adquisición</label>
                                <input type="date" class="form-control" id="fecha_adquisicion" name="fecha_adquisicion">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="costo">Costo (COP)</label>
                                <input type="number" class="form-control" id="costo" name="costo" step="0.01">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" 
                                      placeholder="Notas adicionales sobre el equipo"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Guardar Computador
                            </button>
                            <a href="?controller=computador&action=index" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Ayuda</h5>
                </div>
                <div class="card-body">
                    <p><strong>Campos requeridos:</strong></p>
                    <ul>
                        <li>Serial</li>
                        <li>Modelo</li>
                        <li>Marca</li>
                        <li>Categoría</li>
                    </ul>
                    <p class="mt-3"><strong>Consejos:</strong></p>
                    <ul>
                        <li>Usa un serial único y fácil de identificar</li>
                        <li>Completa toda la información técnica posible</li>
                        <li>La fecha y el costo son opcionales</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    }());
</script>
