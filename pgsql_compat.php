<?php
/**
 * PostgreSQL Compatibility Layer para TestLink 1.9
 * 
 * TestLink 1.9 fue diseñado principalmente para MySQL pero puede funcionar con PostgreSQL
 * Este archivo arregla los problemas de compatibilidad
 */

// Si se está usando PostgreSQL, ajustar el tipo de BD para ADODB
if (defined('DB_TYPE') && DB_TYPE === 'pgsql') {
    // ADODB espera uno de estos tipos para PostgreSQL:
    // 'postgres', 'postgres7', 'postgres8', 'postgres9'
    // Usamos un alias para que ADODB entienda que es PostgreSQL
    if (!defined('ADODB_DB_TYPE')) {
        define('ADODB_DB_TYPE', 'postgres9');
    }
}

// Función auxiliar para filtrar errores de MySQL en PostgreSQL
function testlink_db_filter_error($msg) {
    if (defined('DB_TYPE') && DB_TYPE === 'pgsql') {
        // Ignorar errores específicos de MySQL que no aplican en PostgreSQL
        $ignore_patterns = array(
            '/mysql_connect\(\)/',
            '/mysql_error\(\)/',
        );
        
        foreach ($ignore_patterns as $pattern) {
            if (preg_match($pattern, $msg)) {
                return true;
            }
        }
    }
    return false;
}

?>
