<?php

declare(strict_types=1);

abstract class BaseModel
{
    protected PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}
