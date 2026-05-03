<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><i class="fas fa-reply"></i> Devolver Computador</h3>
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
                <div class="card-header bg-warning">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Confirmar Devolución</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Información de la Asignación:</strong>
                    </div>

                    <table class="table table-bordered mb-4">
                        <tr>
                            <td class="font-weight-bold">Computador:</td>
                            <td>
                                <?= htmlspecialchars($asignacion['marca_nombre'] ?? 'N/A') ?> 
                                <?= htmlspecialchars($asignacion['modelo'] ?? '') ?> 
                                (<?= htmlspecialchars($asignacion['serial'] ?? '') ?>)
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Empleado:</td>
                            <td><?= htmlspecialchars($asignacion['empleado_nombre'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Departamento:</td>
                            <td><?= htmlspecialchars($asignacion['departamento'] ?? '') ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Fecha de Asignación:</td>
                            <td><?= date('d/m/Y H:i', strtotime($asignacion['fecha_asignacion'])) ?></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Tiempo Asignado:</td>
                            <td>
                                <?php 
                                    $fechaAsignacion = new DateTime($asignacion['fecha_asignacion']);
                                    $ahora = new DateTime();
                                    $diff = $ahora->diff($fechaAsignacion);
                                    echo $diff->days . ' días, ' . $diff->h . ' horas';
                                ?>
                            </td>
                        </tr>
                        <?php if (!empty($asignacion['observaciones'])): ?>
                        <tr>
                            <td class="font-weight-bold">Observaciones Anteriores:</td>
                            <td><?= nl2br(htmlspecialchars($asignacion['observaciones'])) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>

                    <form method="POST" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="observaciones">Observaciones de Devolución</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="4" 
                                      placeholder="Estado del computador, daños, etc."></textarea>
                            <small class="form-text text-muted">
                                Describe el estado del computador al devolverse
                            </small>
                        </div>

                        <div class="alert alert-warning">
                            <strong>Advertencia:</strong> 
                            Al confirmar, el computador cambiará a estado "disponible" y podrá volver a asignarse.
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Confirmar Devolución
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
                    <h5 class="mb-0"><i class="fas fa-checklist"></i> Checklist de Devolución</h5>
                </div>
                <div class="card-body">
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="check1">
                        <label class="custom-control-label" for="check1">
                            Verificar estado físico
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="check2">
                        <label class="custom-control-label" for="check2">
                            Revisar funcionamiento
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="check3">
                        <label class="custom-control-label" for="check3">
                            Verificar accesorios completos
                        </label>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="check4">
                        <label class="custom-control-label" for="check4">
                            Registrar observaciones
                        </label>
                    </div>
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
