<?php

declare(strict_types=1);

final class DepartamentoModel extends BaseModel
{
    public function all(): array
    {
        $sql = 'SELECT id, nombre FROM departamentos ORDER BY id DESC';
        return $this->connection->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->connection->prepare('SELECT id, nombre FROM departamentos WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(string $nombre): void
    {
        $stmt = $this->connection->prepare('INSERT INTO departamentos (nombre) VALUES (:nombre)');
        $stmt->execute(['nombre' => $nombre]);
    }

    public function update(int $id, string $nombre): void
    {
        $stmt = $this->connection->prepare('UPDATE departamentos SET nombre = :nombre WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM departamentos WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
