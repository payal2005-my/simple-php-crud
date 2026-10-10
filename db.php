```php
<?php

$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl) {
    $db = parse_url($databaseUrl);

    if (
        $db === false ||
        empty($db['host']) ||
        empty($db['user']) ||
        !isset($db['path']) ||
        $db['path'] === '/'
    ) {
        error_log('Invalid DATABASE_URL configuration.');
        http_response_code(503);
        exit('Database configuration is invalid.');
    }

    $host = $db['host'];
    $port = $db['port'] ?? 3306;
    $dbname = ltrim($db['path'], '/');
    $username = $db['user'];
    $password = $db['pass'] ?? '';
} else {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $dbname = getenv('DB_NAME') ?: 'simple_crud';
    $username = getenv('DB_USER') ?: 'appuser';
    $password = getenv('DB_PASSWORD') ?: '';
}

try {
    $caFile = __DIR__ . '/certs/coolify-ca.crt';

    if (!is_readable($caFile)) {
        throw new RuntimeException('MySQL CA certificate is missing.');
    }

    $pdo = new PDO(
        "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_SSL_CA => $caFile,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
        ]
    );
} catch (Throwable $e) {
    error_log('Database connection failed: ' . $e->getMessage());

    http_response_code(503);
    exit('Database is temporarily unavailable. Please try again later.');
}
```
