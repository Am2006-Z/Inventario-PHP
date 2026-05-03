<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $base = __DIR__;
    $paths = [
        $base . '/lib/' . $class . '.php',
        $base . '/controller/' . $class . '.php',
        $base . '/model/' . $class . '.php',
        $base . '/controller/Auth/' . $class . '.php',
        $base . '/controller/Dashboard/' . $class . '.php',
        $base . '/controller/Computador/' . $class . '.php',
        $base . '/controller/Asignacion/' . $class . '.php',
        $base . '/controller/Usuario/' . $class . '.php',
        $base . '/model/Usuario/' . $class . '.php',
        $base . '/model/Computador/' . $class . '.php',
        $base . '/model/Asignacion/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

session_start();

$config = require __DIR__ . '/lib/conf/config.php';
$connection = Database::getConnection($config);

$controllerName = strtolower((string) ($_GET['controller'] ?? 'auth'));
$action = strtolower((string) ($_GET['action'] ?? 'index'));
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$controllerMap = [
    'auth' => AuthController::class,
    'dashboard' => DashboardController::class,
    'computador' => ComputadorController::class,
    'asignacion' => AsignacionController::class,
    'usuario' => UsuarioController::class,
];

if (!isset($controllerMap[$controllerName])) {
    http_response_code(404);
    echo 'Controlador no encontrado';
    exit;
}

$controllerClass = $controllerMap[$controllerName];
$controller = new $controllerClass($config, $connection);

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Accion no encontrada';
    exit;
}

$id !== null ? $controller->{$action}($id) : $controller->{$action}();
