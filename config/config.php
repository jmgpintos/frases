<?php

//echo __FILE__ . "\n";

define('DEBUG', true); //Activar modo DEBUG

define('ENV', 'local'); //Entorno de ejecucion

define('CONFIG_PATH', ROOT . 'config' . DS); //directorio de los ficheros de configuracion

//carga de ficheros de configuracion
//debug_simple("Cargando ficheros de configuracion<hr>");

foreach (glob(CONFIG_PATH . "*.php") as $filename) {
//    debug_simple('Cargando ' . $filename . '...');
    require_once $filename;
}

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_METHOD', 'index');
define('DEFAULT_LAYOUT', 'default');

define('SESSION_TIME', 15); //tiempo de duracion de la sesion (minutos)
define('HASH_KEY', '573ca1f7efa62');

//Los niveles de LOG ya están definidos en el código fuente de PHP
//define('LOG_EMERG', 0);
//define('LOG_ALERT', 1);
//define('LOG_CRIT', 2);
//define('LOG_ERR', 3);
//define('LOG_WARNING', 4);
//define('LOG_NOTICE', 5);
//define('LOG_INFO', 6);
//define('LOG_DEBUG', 7);

if (DEBUG) {
    define('LOG_LEVEL', LOG_DEBUG);
} else {
    define('LOG_LEVEL', LOG_NOTICE);
}


define('ACCION_EDITAR', 'editar');
define('ACCION_NUEVO', 'nuevo');
