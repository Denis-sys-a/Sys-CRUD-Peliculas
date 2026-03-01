<?php

class DatabaseSingleton
{
    private static ?DatabaseSingleton $instance = null;
    private mysqli $connection;

    private function __construct(array $config)
    {
        $this->connection = new mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database']
        );

        if ($this->connection->connect_error) {
            throw new RuntimeException('Error de conexion: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8mb4');
    }

    public static function getInstance(array $config): DatabaseSingleton
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}