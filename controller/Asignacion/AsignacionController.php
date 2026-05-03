<?php

declare(strict_types=1);

class AsignacionController extends DashboardController
{
    public function index(): void
    {
        $this->verificarPermiso('empleado');

        $asignacionModel = new AsignacionModel($this->connection);
        $asignaciones = $asignacionModel->obtenerActivas();

        $this->render('asignacion/index', [
            'asignaciones' => $asignaciones,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function historial(): void
    {
        $this->verificarPermiso('empleado');

        $asignacionModel = new AsignacionModel($this->connection);
        $asignaciones = $asignacionModel->obtenerHistorico();

        $this->render('asignacion/historial', [
            'asignaciones' => $asignaciones,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function create(): void
    {
        $this->verificarPermiso('empleado');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->guardarAsignacion();
            return;
        }

        $computadorModel = new ComputadorModel($this->connection);
        $usuarioModel = new UsuarioModel($this->connection);

        $this->render('asignacion/create', [
            'computadores' => $computadorModel->obtenerPorEstado('disponible'),
            'usuarios' => $usuarioModel->obtenerTodos(),
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function devolver(): void
    {
        $this->verificarPermiso('empleado');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=asignacion&action=index');
        }

        $asignacionModel = new AsignacionModel($this->connection);
        $asignacion = $asignacionModel->obtenerPorId((int) $id);

        if (!$asignacion) {
            http_response_code(404);
            echo 'Asignación no encontrada';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $observaciones = $_POST['observaciones'] ?? null;
            $asignacionModel->devolver((int) $id, $observaciones);
            $this->redirect('?controller=asignacion&action=index');
            return;
        }

        $this->render('asignacion/devolver', [
            'asignacion' => $asignacion,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function view(): void
    {
        $this->verificarAutenticacion();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=asignacion&action=index');
        }

        $asignacionModel = new AsignacionModel($this->connection);
        $asignacion = $asignacionModel->obtenerPorId((int) $id);

        if (!$asignacion) {
            http_response_code(404);
            echo 'Asignación no encontrada';
            exit;
        }

        $this->render('asignacion/view', [
            'asignacion' => $asignacion,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    private function guardarAsignacion(): void
    {
        $asignacionModel = new AsignacionModel($this->connection);
        $computadorModel = new ComputadorModel($this->connection);

        $computador_id = $_POST['computador_id'] ?? null;
        $usuario_id = $_POST['usuario_id'] ?? null;
        $empleado_nombre = $_POST['empleado_nombre'] ?? '';
        $departamento = $_POST['departamento'] ?? '';
        $observaciones = $_POST['observaciones'] ?? null;

        if (!$computador_id || !$empleado_nombre || !$departamento) {
            $usuarioModel = new UsuarioModel($this->connection);
            $this->render('asignacion/create', [
                'error' => 'Campos requeridos faltantes',
                'computadores' => $computadorModel->obtenerPorEstado('disponible'),
                'usuarios' => $usuarioModel->obtenerTodos(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        $asignacionModel->asignar(
            (int) $computador_id,
            $usuario_id ? (int) $usuario_id : null,
            $empleado_nombre,
            $departamento,
            $observaciones
        );

        $this->redirect('?controller=asignacion&action=index');
    }
}
