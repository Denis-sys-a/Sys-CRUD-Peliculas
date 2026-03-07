<?php

class DatabaseSingleton
{
    private static ?DatabaseSingleton $instance = null;
    private mysqli $connection;

    private function __construct(array $config)
    {
        $this->connection = $this->connect($config);
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

    private function connect(array $config): mysqli
    {
        $host = (string) ($config['host'] ?? 'localhost');
        $user = (string) ($config['user'] ?? 'root');
        $password = (string) ($config['password'] ?? '');
        $database = (string) ($config['database'] ?? 'bd_peliculas');
        $port = (int) ($config['port'] ?? 3306);

        try {
            return new mysqli($host, $user, $password, $database, $port);
        } catch (mysqli_sql_exception $e) {
            $fallbackPassword = (string) ($config['fallback_password'] ?? '');

            if ($password === '' && $fallbackPassword !== '') {
                try {
                    return new mysqli($host, $user, $fallbackPassword, $database, $port);
                } catch (mysqli_sql_exception $fallbackException) {
                    throw new RuntimeException(
                        'No se pudo conectar a MySQL con las credenciales configuradas. '
                        . 'Verifica config/config.php o crea config/config.local.php.',
                        0,
                        $fallbackException
                    );
                }
            }

            throw new RuntimeException(
                'No se pudo conectar a MySQL. Verifica config/config.php o config/config.local.php.',
                0,
                $e
            };
        }
    }
}