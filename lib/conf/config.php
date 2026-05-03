<?php

/**
 * CONFIGURACIÓN DE LA APLICACIÓN
 * Sistema de Inventario de Computadores
 */

return [
    // Información de la app
    'app_name' => 'Inventario de Computadores',
    'app_version' => '1.0.0',
    'app_author' => 'Desarrollo MVC',
    
    // Rutas
    'base_path' => dirname(__DIR__, 2),
    'base_url' => 'http://localhost/inventario/',
    
    // Base de datos SQLite
    'db' => [
        'driver' => 'sqlite',
        'database' => dirname(__DIR__, 2) . '/data/database.sqlite',
    ],
    
    // Configuración de sesión
    'session' => [
        'name' => 'INVENTARIO_SESSION',
        'lifetime' => 3600,
        'secure' => false,
        'http_only' => true,
    ],
    
    // Seguridad
    'security' => [
        'password_algorithm' => PASSWORD_BCRYPT,
        'password_cost' => 10,
    ],
];

