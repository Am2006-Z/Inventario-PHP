<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/conf/config.php';
require_once __DIR__ . '/../lib/Database.php';
require_once __DIR__ . '/../model/BaseModel.php';
require_once __DIR__ . '/../model/Usuario/UsuarioModel.php';
require_once __DIR__ . '/../lib/Logger.php';

$config = require __DIR__ . '/../lib/conf/config.php';
$connection = Database::getConnection($config);

$usuarioModel = new UsuarioModel($connection);

$usuario = 'testuser_cli';
$email = 'testuser_cli@example.com';
$nombre = 'Usuario CLI Test';
$password = 'clave123';
$rol_id = 3; // usuario

try {
    $ok = $usuarioModel->crear($usuario, $email, $nombre, $password, (int)$rol_id);
    if ($ok) {
        echo "CREAR_OK: Usuario creado correctamente\n";
    } else {
        echo "CREAR_FAIL: ejecución retornó false\n";
    }
} catch (Exception $e) {
    Logger::log('scripts/test_create_user.php -> ' . $e->getMessage());
    echo 'EXCEPTION: ' . $e->getMessage() . "\n";
}

// Mostrar últimos 20 líneas del log si existe
$log = __DIR__ . '/../data/error.log';
if (file_exists($log)) {
    echo "\n--- Últimas líneas de data/error.log ---\n";
    $lines = array_slice(file($log), -20);
    foreach ($lines as $line) echo $line;
}
