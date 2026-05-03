<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0"><i class="fas fa-ban"></i> Acceso Denegado (403)</h4>
                </div>
                <div class="card-body">
                    <p class="lead"><?= htmlspecialchars($mensaje ?? 'No tienes permiso para acceder a este recurso.') ?></p>
                    <a href="?controller=dashboard&action=index" class="btn btn-primary">
                        <i class="fas fa-home"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
