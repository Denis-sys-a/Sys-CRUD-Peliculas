<?php
return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'user' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '19m26d08j',
    'database' => getenv('DB_NAME') ?: 'bd_peliculas',
    'port' => (int) (getenv('DB_PORT') ?: 3306),
];