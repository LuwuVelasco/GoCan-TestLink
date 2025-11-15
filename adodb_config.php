<?php
/**
 * Script de inicialización para forzar PostgreSQL en ADODB
 * Se ejecuta antes de que TestLink intente conectarse
 */

// Forzar que ADODB use el driver PostgreSQL
if (!defined('ADODB_FORCE_TYPE')) {
    define('ADODB_FORCE_TYPE', 'postgres7');
}

// Asegurarse que se usa el driver correcto
define('ADODB_USE_POSTGRES', true);

?>
