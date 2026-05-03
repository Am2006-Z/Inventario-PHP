<?php

declare(strict_types=1);

final class DepartamentoController extends BaseController
{
    private DepartamentoModel $model;

    public function __construct(array $config, PDO $connection)
    {
        parent::__construct($config, $connection);
        $this->model = new DepartamentoModel($connection);
    }

    public function index(): void
    {
        $departamentos = $this->model->all();
        $this->render('departamento/index', ['departamentos' => $departamentos]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));

            if ($nombre !== '') {
                $this->model->create($nombre);
            }

            $this->redirect('?controller=departamento&action=index');
        }

        $this->render('departamento/create');
    }

    public function edit(int $id): void
    {
        $departamento = $this->model->find($id);

        if ($departamento === null) {
            http_response_code(404);
            echo 'Departamento no encontrado';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim((string) ($_POST['nombre'] ?? ''));

            if ($nombre !== '') {
                $this->model->update($id, $nombre);
            }

            $this->redirect('?controller=departamento&action=index');
        }

        $this->render('departamento/edit', ['departamento' => $departamento]);
    }

    public function delete(int $id): void
    {
        $this->model->delete($id);
        $this->redirect('?controller=departamento&action=index');
    }
}
