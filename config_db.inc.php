<?php
/**
 * TestLink Database Configuration
 * 
 * This file is auto-generated and uses environment variables from Render
 * TestLink 1.9 funciona mejor con MySQL/MariaDB
 */

// Leer variables de entorno de Render
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'testlink';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_NAME') ?: 'testlink';
$dbPort = getenv('DB_PORT') ?: '3306';

// TestLink 1.9 usa MySQL (ADODB soporta mejor MySQL que PostgreSQL)
define('DB_TYPE', 'mysql');
define('DB_HOST', $dbHost);
define('DB_USER', $dbUser);
define('DB_PASSWD', $dbPassword);
define('DB_NAME', $dbName);
define('DB_PORT', $dbPort);

// Parámetros adicionales
define('DB_TABLE_PREFIX', 'tl_');

?>
