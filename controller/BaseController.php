<?php

declare(strict_types=1);

abstract class BaseController
{
    protected array $config;
    protected PDO $connection;

    public function __construct(array $config, PDO $connection)
    {
        $this->config = $config;
        $this->connection = $connection;
    }

    protected function render(string $viewPath, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $appName = $this->config['app_name'] ?? 'MVC Demo';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $assetBasePath = rtrim($scriptDir, '/');
        if ($assetBasePath === '') {
            $assetBasePath = '/';
        }
        $fullViewPath = dirname(__DIR__) . '/view/' . $viewPath . '.php';

        require dirname(__DIR__) . '/view/partials/header.php';
        require $fullViewPath;
        require dirname(__DIR__) . '/view/partials/footer.php';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }
}
