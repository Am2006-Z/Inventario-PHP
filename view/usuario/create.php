<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="?controller=usuario&action=index" class="btn btn-secondary">
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
                                <label for="usuario">Usuario <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="usuario" name="usuario" 
                                       placeholder="nombre_usuario" required>
                                <small class="form-text text-muted">Único, sin espacios</small>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       placeholder="Nombre y Apellido" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="usuario@ejemplo.com" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="rol_id">Rol <span class="text-danger">*</span></label>
                                <select class="form-control" id="rol_id" name="rol_id" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    <?php foreach ($roles as $rol_option): ?>
                                        <option value="<?= $rol_option['id'] ?>">
                                            <?= ucfirst(htmlspecialchars($rol_option['nombre'])) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="Mínimo 6 caracteres" required minlength="6">
                            <small class="form-text text-muted">Mínimo 6 caracteres</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Crear Usuario
                            </button>
                            <a href="?controller=usuario&action=index" class="btn btn-secondary btn-lg">
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
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Roles Disponibles</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($roles as $rol_info): ?>
                    <div class="mb-3">
                        <strong><?= ucfirst(htmlspecialchars($rol_info['nombre'])) ?></strong>
                        <p class="text-muted small">
                            <?= htmlspecialchars($rol_info['descripcion'] ?? '') ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
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
