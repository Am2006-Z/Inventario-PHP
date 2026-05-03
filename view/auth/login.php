<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">
                        <i class="fas fa-laptop"></i> Inventario de Computadores
                    </h3>

                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="?controller=auth&action=login">
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="usuario" 
                                name="usuario" 
                                placeholder="admin, empleado o usuario"
                                required
                            >
                            <small class="form-text text-muted">Usuarios disponibles: admin, empleado, usuario</small>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Ingresa tu contraseña"
                                required
                            >
                            <small class="form-text text-muted">Contraseñas: admin123, empleado123, usuario123</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </button>
                    </form>

                    <hr>
                    <div class="alert alert-info alert-sm" role="alert">
                        <strong>Usuarios de Prueba:</strong><br>
                        <small>
                            <strong>Admin:</strong> admin / admin123<br>
                            <strong>Empleado:</strong> empleado / empleado123<br>
                            <strong>Usuario:</strong> usuario / usuario123
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 10px;
    }

    .card-title i {
        color: #667eea;
        margin-right: 10px;
    }

    .btn-block {
        border-radius: 5px;
        padding: 10px;
        font-weight: bold;
    }
</style>
