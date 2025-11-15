<?php
/**
 * TestLink Database Configuration para Render
 * 
 * Render proporciona PostgreSQL 16
 * Variables de entorno inyectadas automáticamente por render.yaml
 */

// Leer variables de entorno de Render (DATABASE_URL)
$databaseUrl = getenv('DATABASE_URL');

if (!empty($databaseUrl)) {
    // Parse postgres://user:password@host:port/database
    $pattern = '/postgres:\/\/([^:]+):([^@]+)@([^:]+):(\d+)\/(.+)/';
    if (preg_match($pattern, $databaseUrl, $matches)) {
        $dbUser = $matches[1];
        $dbPassword = $matches[2];
        $dbHost = $matches[3];
        $dbPort = $matches[4];
        $dbName = $matches[5];
    } else {
        // Fallback si el parsing no funciona
        $dbHost = 'localhost';
        $dbPort = '5432';
        $dbUser = 'testlink';
        $dbPassword = '';
        $dbName = 'testlink';
    }
} else {
    // Variables individuales (fallback)
    $dbHost = getenv('DB_HOST') ?: 'localhost';
    $dbUser = getenv('DB_USER') ?: 'testlink';
    $dbPassword = getenv('DB_PASSWORD') ?: '';
    $dbName = getenv('DB_NAME') ?: 'testlink';
    $dbPort = getenv('DB_PORT') ?: '5432';
}

// Configuración para PostgreSQL
define('DB_TYPE', 'pgsql');
define('DB_HOST', $dbHost);
define('DB_USER', $dbUser);
define('DB_PASSWD', $dbPassword);
define('DB_NAME', $dbName);
define('DB_PORT', $dbPort);

// Parámetros adicionales
define('DB_TABLE_PREFIX', 'tl_');

// Debug (comentar en producción)
// error_log("DB Config: host=$dbHost, user=$dbUser, db=$dbName, port=$dbPort");

?>
