<?php

declare(strict_types=1);

final class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(array $config): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $dbFile = $config['db']['database'];
        $dbDir = dirname($dbFile);

        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0777, true);
        }

        $isNewDatabase = !file_exists($dbFile);

        self::$connection = new PDO('sqlite:' . $dbFile);
        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if ($isNewDatabase) {
            self::initializeSchema(self::$connection);
        }

        return self::$connection;
    }

    private static function initializeSchema(PDO $connection): void
    {
        $schemaSql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS roles (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL UNIQUE,
            descripcion TEXT
        );

        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            nombre TEXT NOT NULL,
            rol_id INTEGER NOT NULL,
            activo INTEGER DEFAULT 1,
            fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (rol_id) REFERENCES roles(id)
        );

        CREATE TABLE IF NOT EXISTS marcas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL UNIQUE
        );

        CREATE TABLE IF NOT EXISTS categorias (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL UNIQUE
        );

        CREATE TABLE IF NOT EXISTS computadores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            serial TEXT NOT NULL UNIQUE,
            marca_id INTEGER NOT NULL,
            categoria_id INTEGER NOT NULL,
            modelo TEXT NOT NULL,
            procesador TEXT,
            ram TEXT,
            almacenamiento TEXT,
            so TEXT,
            estado TEXT DEFAULT 'disponible',
            descripcion TEXT,
            fecha_adquisicion DATE,
            costo DECIMAL(10,2),
            costo_moneda TEXT DEFAULT 'COP',
            fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
            usuario_creacion_id INTEGER,
            FOREIGN KEY (marca_id) REFERENCES marcas(id),
            FOREIGN KEY (categoria_id) REFERENCES categorias(id),
            FOREIGN KEY (usuario_creacion_id) REFERENCES usuarios(id)
        );

        CREATE TABLE IF NOT EXISTS asignaciones (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            computador_id INTEGER NOT NULL,
            usuario_id INTEGER,
            empleado_nombre TEXT,
            departamento TEXT,
            fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
            fecha_devolucion DATETIME,
            observaciones TEXT,
            FOREIGN KEY (computador_id) REFERENCES computadores(id),
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );

        CREATE TABLE IF NOT EXISTS bitacora (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            accion TEXT NOT NULL,
            tabla TEXT,
            registro_id INTEGER,
            detalles TEXT,
            fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );
        SQL;

        $connection->exec($schemaSql);

        $count = (int) $connection->query('SELECT COUNT(*) FROM roles')->fetchColumn();

        if ($count === 0) {
            // Insertar roles
            $connection->exec("INSERT INTO roles (nombre, descripcion) VALUES 
                ('admin', 'Administrador del sistema'),
                ('empleado', 'Empleado que gestiona inventario'),
                ('usuario', 'Usuario que recibe computadores')");

            // Insertar usuarios de prueba
            $adminPass = password_hash('admin123', PASSWORD_BCRYPT);
            $empleadoPass = password_hash('empleado123', PASSWORD_BCRYPT);
            $usuarioPass = password_hash('usuario123', PASSWORD_BCRYPT);

            $connection->exec("INSERT INTO usuarios (usuario, email, password, nombre, rol_id) VALUES 
                ('admin', 'admin@inventario.local', '$adminPass', 'Administrador', 1),
                ('empleado', 'empleado@inventario.local', '$empleadoPass', 'Gerente de Inventario', 2),
                ('usuario', 'usuario@inventario.local', '$usuarioPass', 'Usuario Final', 3)");

            // Insertar marcas
            $connection->exec("INSERT INTO marcas (nombre) VALUES 
                ('Dell'), ('HP'), ('Lenovo'), ('ASUS'), ('Apple'), ('Acer'), ('MSI')");

            // Insertar categorías
            $connection->exec("INSERT INTO categorias (nombre) VALUES 
                ('Laptop'), ('Desktop'), ('Monitor'), ('Impresora'), ('Router'), ('Servidor')");
        }
    }
}
