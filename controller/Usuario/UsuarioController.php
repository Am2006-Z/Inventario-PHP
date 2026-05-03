<?php

declare(strict_types=1);

class UsuarioController extends DashboardController
{

    // Logger disponible en lib/Logger.php
    public function __construct(array $config = [], PDO $connection = null)
    {
        // Evitar romper la construcción existente; el framework crea controladores pasando config y connection.
        // No hacemos nada aquí; la inclusión de Logger se realiza de forma estática mediante require_once.
    }
    public function index(): void
    {
        $this->verificarPermiso('admin');

        $usuarioModel = new UsuarioModel($this->connection);
        $usuarios = $usuarioModel->obtenerTodos();

        $this->render('usuario/index', [
            'usuarios' => $usuarios,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function create(): void
    {
        $this->verificarPermiso('admin');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->guardar();
            return;
        }

        $usuarioModel = new UsuarioModel($this->connection);
        $this->render('usuario/create', [
            'roles' => $usuarioModel->obtenerRoles(),
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    private function guardar(): void
    {
        require_once dirname(__DIR__, 2) . '/lib/Logger.php';

        $usuarioModel = new UsuarioModel($this->connection);
        
        $usuario = $_POST['usuario'] ?? '';
        $email = $_POST['email'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $password = $_POST['password'] ?? '';
        $rol_id = $_POST['rol_id'] ?? null;

        if (!$usuario || !$email || !$nombre || !$password || !$rol_id) {
            $this->render('usuario/create', [
                'error' => 'Todos los campos son requeridos',
                'roles' => $usuarioModel->obtenerRoles(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $this->render('usuario/create', [
                'error' => 'La contraseña debe tener al menos 6 caracteres',
                'roles' => $usuarioModel->obtenerRoles(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        try {
            $ok = $usuarioModel->crear($usuario, $email, $nombre, $password, (int) $rol_id);
        } catch (Exception $e) {
            Logger::log('Usuario::crear -> ' . $e->getMessage());
            $this->render('usuario/create', [
                'error' => 'Ocurrió un error al crear el usuario. Detalles registrados en el servidor.',
                'roles' => $usuarioModel->obtenerRoles(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        if (!$ok) {
            Logger::log(sprintf('Usuario::crear -> ejecución returned false for usuario=%s,email=%s', $usuario, $email));
            $this->render('usuario/create', [
                'error' => 'No se pudo crear el usuario, verifique valores únicos (usuario/email).',
                'roles' => $usuarioModel->obtenerRoles(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        $this->redirect('?controller=usuario&action=index');
    }
}
