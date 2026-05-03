<?php

declare(strict_types=1);

final class CiudadController extends BaseController
{
    private CiudadModel $ciudadModel;
    private DepartamentoModel $departamentoModel;

    public function __construct(array $config, PDO $connection)
    {
        parent::__construct($config, $connection);
        $this->ciudadModel = new CiudadModel($connection);
        $this->departamentoModel = new DepartamentoModel($connection);
    }

    public function index(): void
    {
        $ciudades = $this->ciudadModel->allWithDepartamento();
        $this->render('ciudad/index', ['ciudades' => $ciudades]);
    }

    public function create(): void
    {
        $departamentos = $this->departamentoModel->all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $departamentoId = (int) ($_POST['departamento_id'] ?? 0);

            if ($nombre !== '' && $departamentoId > 0) {
                $this->ciudadModel->create($nombre, $departamentoId);
            }

            $this->redirect('?controller=ciudad&action=index');
        }

        $this->render('ciudad/create', ['departamentos' => $departamentos]);
    }

    public function edit(int $id): void
    {
        $ciudad = $this->ciudadModel->find($id);
        $departamentos = $this->departamentoModel->all();

        if ($ciudad === null) {
            http_response_code(404);
            echo 'Ciudad no encontrada';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));
            $departamentoId = (int) ($_POST['departamento_id'] ?? 0);

            if ($nombre !== '' && $departamentoId > 0) {
                $this->ciudadModel->update($id, $nombre, $departamentoId);
            }

            $this->redirect('?controller=ciudad&action=index');
        }

        $this->render('ciudad/edit', [
            'ciudad' => $ciudad,
            'departamentos' => $departamentos,
        ]);
    }

    public function delete(int $id): void
    {
        $this->ciudadModel->delete($id);
        $this->redirect('?controller=ciudad&action=index');
    }
}
