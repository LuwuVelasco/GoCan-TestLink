<?php
/**
 * Archivo de diagnóstico para TestLink
 * Accede a: https://testlink-gocan.onrender.com/diag.php
 */

echo "<h1>TestLink Diagnostics</h1>";

// 1. Verificar variables de entorno
echo "<h2>Environment Variables</h2>";
echo "<pre>";
echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? "SET" : "NOT SET") . "\n";
echo "DB_HOST: " . getenv('DB_HOST') . "\n";
echo "DB_USER: " . getenv('DB_USER') . "\n";
echo "DB_NAME: " . getenv('DB_NAME') . "\n";
echo "DB_PORT: " . getenv('DB_PORT') . "\n";
echo "</pre>";

// 2. Verificar extensiones PHP
echo "<h2>PHP Extensions</h2>";
echo "<pre>";
$extensions = array('pdo', 'pdo_pgsql', 'zip', 'xml', 'json', 'curl');
foreach ($extensions as $ext) {
    echo $ext . ": " . (extension_loaded($ext) ? "LOADED" : "NOT LOADED") . "\n";
}
echo "</pre>";

// 3. Cargar config_db.inc.php
echo "<h2>Database Configuration</h2>";
echo "<pre>";
require_once('config_db.inc.php');
echo "DB_TYPE: " . (defined('DB_TYPE') ? DB_TYPE : "NOT DEFINED") . "\n";
echo "DB_HOST: " . (defined('DB_HOST') ? DB_HOST : "NOT DEFINED") . "\n";
echo "DB_USER: " . (defined('DB_USER') ? DB_USER : "NOT DEFINED") . "\n";
echo "DB_NAME: " . (defined('DB_NAME') ? DB_NAME : "NOT DEFINED") . "\n";
echo "DB_PORT: " . (defined('DB_PORT') ? DB_PORT : "NOT DEFINED") . "\n";
echo "</pre>";

// 4. Intentar conexión a BD
echo "<h2>Database Connection Test</h2>";
echo "<pre>";
try {
    $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWD);
    echo "Connection: SUCCESS\n";
    $pdo = null;
} catch (PDOException $e) {
    echo "Connection: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}
echo "</pre>";

// 5. Verificar archivos de configuración
echo "<h2>Configuration Files</h2>";
echo "<pre>";
echo "config.inc.php: " . (file_exists('config.inc.php') ? "EXISTS" : "MISSING") . "\n";
echo "config_db.inc.php: " . (file_exists('config_db.inc.php') ? "EXISTS" : "MISSING") . "\n";
echo "pgsql_compat.php: " . (file_exists('pgsql_compat.php') ? "EXISTS" : "MISSING") . "\n";
echo "login.php: " . (file_exists('login.php') ? "EXISTS" : "MISSING") . "\n";
echo "</pre>";

// 6. Permisos
echo "<h2>Directory Permissions</h2>";
echo "<pre>";
$dirs = array('logs', 'upload_area', 'gui/templates_c');
foreach ($dirs as $dir) {
    $exists = is_dir($dir);
    $writable = is_writable($dir);
    echo $dir . ": " . ($exists ? "EXISTS" : "MISSING") . " - " . ($writable ? "WRITABLE" : "NOT WRITABLE") . "\n";
}
echo "</pre>";

echo "<h2>PHP Info</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";
echo "Display Errors: " . ini_get('display_errors') . "\n";
echo "Error Reporting: " . error_reporting() . "\n";
echo "</pre>";

?>
