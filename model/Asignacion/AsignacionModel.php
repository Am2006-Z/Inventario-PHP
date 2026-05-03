<?php

declare(strict_types=1);

class AsignacionModel extends BaseModel
{
    public function obtenerTodas(): array
    {
        $sql = 'SELECT a.*, c.serial, c.modelo, m.nombre as marca_nombre, 
                u.nombre as usuario_nombre
                FROM asignaciones a
                LEFT JOIN computadores c ON a.computador_id = c.id
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.fecha_devolucion IS NULL
                ORDER BY a.fecha_asignacion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerActivas(): array
    {
        $sql = 'SELECT a.*, c.serial, c.modelo, m.nombre as marca_nombre, 
                u.nombre as usuario_nombre
                FROM asignaciones a
                LEFT JOIN computadores c ON a.computador_id = c.id
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.fecha_devolucion IS NULL
                ORDER BY a.fecha_asignacion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerHistorico(): array
    {
        $sql = 'SELECT a.*, c.serial, c.modelo, m.nombre as marca_nombre, 
                u.nombre as usuario_nombre
                FROM asignaciones a
                LEFT JOIN computadores c ON a.computador_id = c.id
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.fecha_devolucion IS NOT NULL
                ORDER BY a.fecha_devolucion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT a.*, c.serial, c.modelo, m.nombre as marca_nombre, 
                u.nombre as usuario_nombre
                FROM asignaciones a
                LEFT JOIN computadores c ON a.computador_id = c.id
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function obtenerActivaDelComputador(int $computador_id): ?array
    {
        $sql = 'SELECT * FROM asignaciones 
                WHERE computador_id = :computador_id AND fecha_devolucion IS NULL
                ORDER BY fecha_asignacion DESC LIMIT 1';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':computador_id' => $computador_id]);
        return $stmt->fetch() ?: null;
    }

    public function asignar(
        int $computador_id,
        ?int $usuario_id,
        string $empleado_nombre,
        string $departamento,
        ?string $observaciones
    ): bool {
        $sql = 'INSERT INTO asignaciones (computador_id, usuario_id, empleado_nombre, departamento, observaciones)
                VALUES (:computador_id, :usuario_id, :empleado_nombre, :departamento, :observaciones)';
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->execute([
            ':computador_id' => $computador_id,
            ':usuario_id' => $usuario_id,
            ':empleado_nombre' => $empleado_nombre,
            ':departamento' => $departamento,
            ':observaciones' => $observaciones
        ]);

        if ($result) {
            // Actualizar estado del computador a asignado
            $sql2 = 'UPDATE computadores SET estado = :estado WHERE id = :id';
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->execute([':estado' => 'asignado', ':id' => $computador_id]);
        }

        return $result;
    }

    public function devolver(int $id, ?string $observaciones): bool
    {
        $asignacion = $this->obtenerPorId($id);
        if (!$asignacion) {
            return false;
        }

        $sql = 'UPDATE asignaciones SET fecha_devolucion = CURRENT_TIMESTAMP, observaciones = :observaciones
                WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $result = $stmt->execute([
            ':id' => $id,
            ':observaciones' => $observaciones
        ]);

        if ($result) {
            // Actualizar estado del computador a disponible
            $sql2 = 'UPDATE computadores SET estado = :estado WHERE id = :id';
            $stmt2 = $this->connection->prepare($sql2);
            $stmt2->execute([':estado' => 'disponible', ':id' => $asignacion['computador_id']]);
        }

        return $result;
    }

    public function obtenerPorComputador(int $computador_id): array
    {
        $sql = 'SELECT a.*, u.nombre as usuario_nombre
                FROM asignaciones a
                LEFT JOIN usuarios u ON a.usuario_id = u.id
                WHERE a.computador_id = :computador_id
                ORDER BY a.fecha_asignacion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':computador_id' => $computador_id]);
        return $stmt->fetchAll();
    }
}
