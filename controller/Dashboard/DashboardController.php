<?php

declare(strict_types=1);

class DashboardController extends BaseController
{
    public function index(): void
    {
        $this->verificarAutenticacion();

        $usuarioRol = $_SESSION['usuario_rol'] ?? '';

        $computadorModel = new ComputadorModel($this->connection);
        $asignacionModel = new AsignacionModel($this->connection);

        $data = [
            'rol' => $usuarioRol,
            'usuario' => $_SESSION['usuario_nombre'] ?? '',
            'computadores' => $computadorModel->obtenerTodos(),
            'estadisticas' => $computadorModel->obtenerEstadisticas(),
            'asignacionesActivas' => $asignacionModel->obtenerActivas(),
        ];

        $this->render('dashboard/index', $data);
    }

    protected function verificarAutenticacion(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            $this->redirect('?controller=auth&action=index');
        }
    }

    protected function verificarPermiso(string $rolRequerido): void
    {
        $this->verificarAutenticacion();

        $rol = $_SESSION['usuario_rol'] ?? '';
        $rolesPermitidos = [
            'admin' => ['admin'],
            'empleado' => ['admin', 'empleado'],
            'usuario' => ['admin', 'empleado', 'usuario']
        ];

        if (!in_array($rol, $rolesPermitidos[$rolRequerido] ?? [])) {
            http_response_code(403);
            $this->render('error/forbidden', ['mensaje' => 'No tienes permiso para acceder a este recurso']);
            exit;
        }
    }
}
