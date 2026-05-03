<?php

declare(strict_types=1);

class ComputadorController extends DashboardController
{
    public function index(): void
    {
        $this->verificarAutenticacion();

        $computadorModel = new ComputadorModel($this->connection);
        $computadores = $computadorModel->obtenerTodos();

        $this->render('computador/index', [
            'computadores' => $computadores,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function create(): void
    {
        $this->verificarPermiso('empleado');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->guardar();
            return;
        }

        $computadorModel = new ComputadorModel($this->connection);
        $this->render('computador/create', [
            'marcas' => $computadorModel->obtenerMarcas(),
            'categorias' => $computadorModel->obtenerCategorias(),
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function edit(): void
    {
        $this->verificarPermiso('empleado');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=computador&action=index');
        }

        $computadorModel = new ComputadorModel($this->connection);
        $computador = $computadorModel->obtenerPorId((int) $id);

        if (!$computador) {
            http_response_code(404);
            echo 'Computador no encontrado';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->actualizar((int) $id);
            return;
        }

        $this->render('computador/edit', [
            'computador' => $computador,
            'marcas' => $computadorModel->obtenerMarcas(),
            'categorias' => $computadorModel->obtenerCategorias(),
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function view(): void
    {
        $this->verificarAutenticacion();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=computador&action=index');
        }

        $computadorModel = new ComputadorModel($this->connection);
        $asignacionModel = new AsignacionModel($this->connection);

        $computador = $computadorModel->obtenerPorId((int) $id);
        if (!$computador) {
            http_response_code(404);
            echo 'Computador no encontrado';
            exit;
        }

        $asignaciones = $asignacionModel->obtenerPorComputador((int) $id);

        $this->render('computador/view', [
            'computador' => $computador,
            'asignaciones' => $asignaciones,
            'rol' => $_SESSION['usuario_rol'] ?? ''
        ]);
    }

    public function delete(): void
    {
        $this->verificarPermiso('admin');

        $id = $_GET['id'] ?? null;
        if (!$id) {
            $this->redirect('?controller=computador&action=index');
        }

        $computadorModel = new ComputadorModel($this->connection);
        $computadorModel->eliminar((int) $id);

        $this->redirect('?controller=computador&action=index');
    }

    private function guardar(): void
    {
        $computadorModel = new ComputadorModel($this->connection);
        $serial = $_POST['serial'] ?? '';
        $marca_id = $_POST['marca_id'] ?? null;
        $categoria_id = $_POST['categoria_id'] ?? null;
        $modelo = $_POST['modelo'] ?? '';
        $procesador = $_POST['procesador'] ?? '';
        $ram = $_POST['ram'] ?? '';
        $almacenamiento = $_POST['almacenamiento'] ?? '';
        $so = $_POST['so'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_adquisicion = $_POST['fecha_adquisicion'] ?? null;
        $costo = isset($_POST['costo']) ? (float) $_POST['costo'] : null;

        if (!$serial || !$marca_id || !$categoria_id || !$modelo) {
            $this->render('computador/create', [
                'error' => 'Campos requeridos faltantes',
                'marcas' => $computadorModel->obtenerMarcas(),
                'categorias' => $computadorModel->obtenerCategorias(),
                'rol' => $_SESSION['usuario_rol'] ?? ''
            ]);
            return;
        }

        $computadorModel->crear(
            $serial,
            (int) $marca_id,
            (int) $categoria_id,
            $modelo,
            $procesador,
            $ram,
            $almacenamiento,
            $so,
            $descripcion ?: null,
            $fecha_adquisicion ?: null,
            $costo,
            (int) $_SESSION['usuario_id']
        );

        $this->redirect('?controller=computador&action=index');
    }

    private function actualizar(int $id): void
    {
        $computadorModel = new ComputadorModel($this->connection);

        $marca_id = $_POST['marca_id'] ?? null;
        $categoria_id = $_POST['categoria_id'] ?? null;
        $modelo = $_POST['modelo'] ?? '';
        $procesador = $_POST['procesador'] ?? '';
        $ram = $_POST['ram'] ?? '';
        $almacenamiento = $_POST['almacenamiento'] ?? '';
        $so = $_POST['so'] ?? '';
        $estado = $_POST['estado'] ?? 'disponible';
        $descripcion = $_POST['descripcion'] ?? '';
        $fecha_adquisicion = $_POST['fecha_adquisicion'] ?? null;
        $costo = isset($_POST['costo']) ? (float) $_POST['costo'] : null;

        $computadorModel->actualizar(
            $id,
            (int) $marca_id,
            (int) $categoria_id,
            $modelo,
            $procesador,
            $ram,
            $almacenamiento,
            $so,
            $estado,
            $descripcion ?: null,
            $fecha_adquisicion ?: null,
            $costo
        );

        $this->redirect('?controller=computador&action=view&id=' . $id);
    }
}
