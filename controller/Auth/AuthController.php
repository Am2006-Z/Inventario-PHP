<?php

declare(strict_types=1);

class AuthController extends BaseController
{
    public function index(): void
    {
        if ($this->obtenerUsuarioSesion()) {
            $this->redirect('?controller=dashboard&action=index');
        }
        $this->render('auth/login', ['error' => null]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?controller=auth&action=index');
        }

        $usuario = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$usuario || !$password) {
            $this->render('auth/login', ['error' => 'Usuario y contraseña requeridos']);
            return;
        }

        $usuarioModel = new UsuarioModel($this->connection);
        $usuarioDb = $usuarioModel->obtenerPorUsuario($usuario);

        if (!$usuarioDb || !$usuarioModel->verificarPassword($password, $usuarioDb['password'])) {
            $this->render('auth/login', ['error' => 'Usuario o contraseña incorrectos']);
            return;
        }

        $_SESSION['usuario_id'] = $usuarioDb['id'];
        $_SESSION['usuario_nombre'] = $usuarioDb['nombre'];
        $_SESSION['usuario_rol'] = $usuarioDb['rol_nombre'];
        $_SESSION['usuario_email'] = $usuarioDb['email'];

        $this->redirect('?controller=dashboard&action=index');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('?controller=auth&action=index');
    }

    protected function obtenerUsuarioSesion(): ?array
    {
        if (!isset($_SESSION['usuario_id'])) {
            return null;
        }

        $usuarioModel = new UsuarioModel($this->connection);
        return $usuarioModel->obtenerPorId((int) $_SESSION['usuario_id']);
    }
}
