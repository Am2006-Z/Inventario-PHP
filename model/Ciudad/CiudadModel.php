z<?php

declare(strict_types=1);

final class CiudadModel extends BaseModel
{
    public function allWithDepartamento(): array
    {
        $sql = 'SELECT c.id, c.nombre, c.departamento_id, d.nombre AS departamento_nombre
                FROM ciudades c
                INNER JOIN departamentos d ON d.id = c.departamento_id
                ORDER BY c.id DESC';

        return $this->connection->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->connection->prepare('SELECT id, nombre, departamento_id FROM ciudades WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(string $nombre, int $departamentoId): void
    {
        $stmt = $this->connection->prepare('INSERT INTO ciudades (nombre, departamento_id) VALUES (:nombre, :departamento_id)');
        $stmt->execute([
            'nombre' => $nombre,
            'departamento_id' => $departamentoId,
        ]);
    }

    public function update(int $id, string $nombre, int $departamentoId): void
    {
        $stmt = $this->connection->prepare('UPDATE ciudades SET nombre = :nombre, departamento_id = :departamento_id WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'departamento_id' => $departamentoId,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM ciudades WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
