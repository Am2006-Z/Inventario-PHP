<?php

declare(strict_types=1);

final class Logger
{
    public static function log(string $message): void
    {
        $file = dirname(__DIR__) . '/data/error.log';
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $time = date('Y-m-d H:i:s');
        $entry = sprintf("[%s] %s\n", $time, $message);
        @file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    }
}
