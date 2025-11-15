<?php
/**
 * TestLink Database Configuration
 * 
 * This file is auto-generated and uses environment variables from Render
 * It supports both MySQL/MariaDB and PostgreSQL
 */

// Detectar tipo de base de datos por la URL de conexión
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'testlink';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_NAME') ?: 'testlink';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbType = getenv('DB_TYPE') ?: 'mysql'; // 'mysql' o 'pgsql'

// Si INTERNAL_DB_DSURL viene de Render (PostgreSQL)
$internalDbUrl = getenv('INTERNAL_DB_DSURL');
if (!empty($internalDbUrl)) {
    // Parse PostgreSQL URL: postgres://user:password@host:port/database
    $dbType = 'pgsql';
    $pattern = '/postgres:\/\/([^:]+):([^@]+)@([^:]+):(\d+)\/(.+)/';
    if (preg_match($pattern, $internalDbUrl, $matches)) {
        $dbUser = $matches[1];
        $dbPassword = $matches[2];
        $dbHost = $matches[3];
        $dbPort = $matches[4];
        $dbName = $matches[5];
    }
}

// Configuración de TestLink para MySQL
if ($dbType === 'mysql') {
    define('DB_TYPE', 'mysql');
    define('DB_HOST', $dbHost);
    define('DB_USER', $dbUser);
    define('DB_PASSWD', $dbPassword);
    define('DB_NAME', $dbName);
    define('DB_PORT', $dbPort);
}
// Configuración de TestLink para PostgreSQL
elseif ($dbType === 'pgsql') {
    define('DB_TYPE', 'pgsql');
    define('DB_HOST', $dbHost);
    define('DB_USER', $dbUser);
    define('DB_PASSWD', $dbPassword);
    define('DB_NAME', $dbName);
    define('DB_PORT', $dbPort);
}

// Parámetros adicionales
define('DB_TABLE_PREFIX', 'tl_');

?>
