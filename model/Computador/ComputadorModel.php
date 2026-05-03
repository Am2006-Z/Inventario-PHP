<?php

declare(strict_types=1);

class ComputadorModel extends BaseModel
{
    public function obtenerTodos(): array
    {
        $sql = 'SELECT c.*, m.nombre as marca_nombre, cat.nombre as categoria_nombre 
                FROM computadores c
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN categorias cat ON c.categoria_id = cat.id
                ORDER BY c.fecha_creacion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT c.*, m.nombre as marca_nombre, cat.nombre as categoria_nombre 
                FROM computadores c
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN categorias cat ON c.categoria_id = cat.id
                WHERE c.id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function obtenerPorEstado(string $estado): array
    {
        $sql = 'SELECT c.*, m.nombre as marca_nombre, cat.nombre as categoria_nombre 
                FROM computadores c
                LEFT JOIN marcas m ON c.marca_id = m.id
                LEFT JOIN categorias cat ON c.categoria_id = cat.id
                WHERE c.estado = :estado
                ORDER BY c.fecha_creacion DESC';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':estado' => $estado]);
        return $stmt->fetchAll();
    }

    public function crear(
        string $serial,
        int $marca_id,
        int $categoria_id,
        string $modelo,
        string $procesador,
        string $ram,
        string $almacenamiento,
        string $so,
        ?string $descripcion,
        ?string $fecha_adquisicion,
        ?float $costo,
        int $usuario_id
    ): bool {
        $sql = 'INSERT INTO computadores (serial, marca_id, categoria_id, modelo, procesador, 
                ram, almacenamiento, so, descripcion, fecha_adquisicion, costo, usuario_creacion_id) 
                VALUES (:serial, :marca_id, :categoria_id, :modelo, :procesador, :ram, 
                :almacenamiento, :so, :descripcion, :fecha_adquisicion, :costo, :usuario_id)';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':serial' => $serial,
            ':marca_id' => $marca_id,
            ':categoria_id' => $categoria_id,
            ':modelo' => $modelo,
            ':procesador' => $procesador,
            ':ram' => $ram,
            ':almacenamiento' => $almacenamiento,
            ':so' => $so,
            ':descripcion' => $descripcion,
            ':fecha_adquisicion' => $fecha_adquisicion,
            ':costo' => $costo,
            ':usuario_id' => $usuario_id
        ]);
    }

    public function actualizar(
        int $id,
        int $marca_id,
        int $categoria_id,
        string $modelo,
        string $procesador,
        string $ram,
        string $almacenamiento,
        string $so,
        string $estado,
        ?string $descripcion,
        ?string $fecha_adquisicion,
        ?float $costo
    ): bool {
        $sql = 'UPDATE computadores SET marca_id = :marca_id, categoria_id = :categoria_id, 
                modelo = :modelo, procesador = :procesador, ram = :ram, almacenamiento = :almacenamiento,
                so = :so, estado = :estado, descripcion = :descripcion, 
                fecha_adquisicion = :fecha_adquisicion, costo = :costo
                WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':marca_id' => $marca_id,
            ':categoria_id' => $categoria_id,
            ':modelo' => $modelo,
            ':procesador' => $procesador,
            ':ram' => $ram,
            ':almacenamiento' => $almacenamiento,
            ':so' => $so,
            ':estado' => $estado,
            ':descripcion' => $descripcion,
            ':fecha_adquisicion' => $fecha_adquisicion,
            ':costo' => $costo
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = 'DELETE FROM computadores WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerMarcas(): array
    {
        $sql = 'SELECT * FROM marcas ORDER BY nombre';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerCategorias(): array
    {
        $sql = 'SELECT * FROM categorias ORDER BY nombre';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function obtenerEstadisticas(): array
    {
        $sql = 'SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN estado = "disponible" THEN 1 ELSE 0 END) as disponibles,
                SUM(CASE WHEN estado = "asignado" THEN 1 ELSE 0 END) as asignados,
                SUM(CASE WHEN estado = "mantenimiento" THEN 1 ELSE 0 END) as mantenimiento,
                SUM(CASE WHEN estado = "fuera_uso" THEN 1 ELSE 0 END) as fuera_uso,
                SUM(costo) as costo_total
                FROM computadores';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch() ?: [];
    }
}
