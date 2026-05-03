<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-link"></i> Crear Nueva Asignación</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=asignacion&action=index" class="btn btn-secondary">
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
                        <h5 class="mb-3"><i class="fas fa-laptop"></i> Seleccionar Computador</h5>
                        
                        <div class="form-group">
                            <label for="computador_id">Computador Disponible <span class="text-danger">*</span></label>
                            <select class="form-control" id="computador_id" name="computador_id" required>
                                <option value="">-- Selecciona un computador --</option>
                                <?php foreach ($computadores as $comp): ?>
                                    <option value="<?= $comp['id'] ?>">
                                        <?= htmlspecialchars($comp['marca_nombre'] ?? 'N/A') ?> 
                                        <?= htmlspecialchars($comp['modelo']) ?> 
                                        (Serial: <?= htmlspecialchars($comp['serial']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                Solo se muestran computadores disponibles
                            </small>
                        </div>

                        <hr>
                        <h5 class="mb-3"><i class="fas fa-user"></i> Información del Receptor</h5>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="empleado_nombre">Nombre del Empleado <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="empleado_nombre" name="empleado_nombre" 
                                       placeholder="Nombre completo" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="departamento">Departamento <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="departamento" name="departamento" 
                                       placeholder="ej: Recursos Humanos" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="usuario_id">Usuario del Sistema (Opcional)</label>
                            <select class="form-control" id="usuario_id" name="usuario_id">
                                <option value="">-- Sin usuario del sistema --</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id'] ?>">
                                        <?= htmlspecialchars($usuario['nombre']) ?> 
                                        (<?= htmlspecialchars($usuario['rol_nombre']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                Si el empleado tiene usuario en el sistema, selecciona su cuenta
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" 
                                      placeholder="Notas sobre la asignación (opcional)"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Confirmar Asignación
                            </button>
                            <a href="?controller=asignacion&action=index" class="btn btn-secondary btn-lg">
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
                    <p><strong>Pasos para asignar:</strong></p>
                    <ol>
                        <li>Selecciona un computador disponible</li>
                        <li>Ingresa los datos del empleado receptor</li>
                        <li>Selecciona el usuario del sistema (opcional)</li>
                        <li>Haz clic en confirmar</li>
                    </ol>
                    
                    <hr>
                    
                    <p><strong>Nota:</strong></p>
                    <ul>
                        <li>Los campos marcados con * son obligatorios</li>
                        <li>El computador cambiará a estado "asignado"</li>
                        <li>Puedes ver el historial de asignaciones en cualquier momento</li>
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
