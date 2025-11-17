<?php
/**
 * TestLink - DB config para Render (PostgreSQL)
 */

define('DB_TYPE', 'pgsql');

define('DB_HOST',   getenv('DB_HOST')   ?: 'localhost');
define('DB_NAME',   getenv('DB_NAME')   ?: 'testlink');
define('DB_USER',   getenv('DB_USER')   ?: 'testlink_user');
define('DB_PASSWD', getenv('DB_PASSWORD') ?: '');
define('DB_PORT',   getenv('DB_PORT')   ?: '5432');

// Prefijo de tablas (puedes cambiarlo si quieres separar varias instancias)
define('DB_TABLE_PREFIX', 'tl_');
?>