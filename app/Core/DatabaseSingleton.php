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
        $database = (string) ($config['database'] ?? 'bd_peliculas');
        $port = (int) ($config['port'] ?? 3306);

        $primaryPassword = (string) ($config['password'] ?? '');
        $fallbackPassword = (string) ($config['fallback_password'] ?? '');

        $passwordAttempts = array_values(array_unique([$primaryPassword, $fallbackPassword, 'root', '']));

        $driver = new mysqli_driver();
        $previousReportMode = $driver->report_mode;
        $driver->report_mode = MYSQLI_REPORT_OFF;

        $lastError = '';

        foreach ($passwordAttempts as $attemptPassword) {
            $connection = @new mysqli($host, $user, $attemptPassword, $database, $port);

            if ($connection->connect_errno === 0) {
                $driver->report_mode = $previousReportMode;

                return $connection;
            }

            $lastError = $connection->connect_error;
            $connection->close();
        }

        $driver->report_mode = $previousReportMode;

        throw new RuntimeException('No se pudo conectar a MySQL. Verifica config/config.local.php. Error original: ' . $lastError);
    }
}