<?php
// Config de base de datos para TestLink 1.9.20 con PostgreSQL en Render

define('DB_TYPE', 'pgsql');

define('DB_USER', getenv('DB_USER') ?: 'testlink_user');
define('DB_PASS', getenv('DB_PASSWORD') ?: 'jGPyBHdk19jm9wcAFZ60vMbVPnCnbPU7');
define('DB_HOST', getenv('DB_HOST') ?: 'dpg-d4cmlj2li9vc73c3bok0-a');
define('DB_NAME', getenv('DB_NAME') ?: 'testlink_lqf7');

// Prefijo de tablas (lo normal es dejarlo vacío)
define('DB_TABLE_PREFIX', '');
?>