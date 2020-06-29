<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

#O nome do padrão usado aqui é static creation method
class ConnectionCreator
{
    public static function createConnection(): \PDO
    {
        // $databasePath = __DIR__ . '/../../../banco.sqlite';
        $connection = new \PDO('mysql:host=localhost;dbname=bancodeteste', 'root', '123456');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}