<?php

declare(strict_types=1);

class UsuarioModel extends BaseModel
{
    public function obtenerPorUsuario(string $usuario): ?array
    {
        $sql = 'SELECT u.*, r.nombre as rol_nombre FROM usuarios u
                LEFT JOIN roles r ON u.rol_id = r.id
                WHERE u.usuario = :usuario AND u.activo = 1';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT u.*, r.nombre as rol_nombre FROM usuarios u
                LEFT JOIN roles r ON u.rol_id = r.id
                WHERE u.id = :id AND u.activo = 1';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function obtenerTodos(): array
    {
        $sql = 'SELECT u.*, r.nombre as rol_nombre FROM usuarios u
                LEFT JOIN roles r ON u.rol_id = r.id
                WHERE u.activo = 1
                ORDER BY u.nombre';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crear(string $usuario, string $email, string $nombre, string $password, int $rol_id): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = 'INSERT INTO usuarios (usuario, email, nombre, password, rol_id) 
                VALUES (:usuario, :email, :nombre, :password, :rol_id)';
        $stmt = $this->connection->prepare($sql);
        try {
            return (bool) $stmt->execute([
                ':usuario' => $usuario,
                ':email' => $email,
                ':nombre' => $nombre,
                ':password' => $hashedPassword,
                ':rol_id' => $rol_id
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Error al insertar usuario en la base de datos: ' . $e->getMessage());
        }
    }

    public function actualizar(int $id, string $nombre, string $email): bool
    {
        $sql = 'UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':email' => $email
        ]);
    }

    public function cambiarPassword(int $id, string $passwordActual, string $passwordNueva): bool
    {
        $usuario = $this->obtenerPorId($id);
        if (!$usuario || !password_verify($passwordActual, $usuario['password'])) {
            return false;
        }

        $hashedPassword = password_hash($passwordNueva, PASSWORD_BCRYPT);
        $sql = 'UPDATE usuarios SET password = :password WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':password' => $hashedPassword
        ]);
    }

    public function verificarPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function eliminar(int $id): bool
    {
        $sql = 'UPDATE usuarios SET activo = 0 WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerRoles(): array
    {
        $sql = 'SELECT * FROM roles ORDER BY nombre';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
