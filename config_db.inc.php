<?php
/**
 * TestLink Database Configuration para Render
 * 
 * Render proporciona PostgreSQL y variables de entorno inyectadas por render.yaml
 */

// Leer variables de entorno de Render
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'testlink';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_NAME') ?: 'testlink';
$dbPort = getenv('DB_PORT') ?: '5432';

// Fallback a DATABASE_URL si está disponible
if (empty($dbHost) || $dbHost === 'localhost') {
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
        }
    }
}

// Validar que tenemos valores no-vacíos
if (empty($dbHost) || $dbHost === 'localhost') {
    // Si aún estamos en localhost, esto es desarrollo local
    // Las credenciales por defecto son para desarrollo
    // En producción (Render) siempre tendrá variables de entorno
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
