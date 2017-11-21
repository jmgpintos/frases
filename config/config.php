<?php

//echo __FILE__ . "\n";

define('DEBUG', true); //Activar modo DEBUG

define('ENV', 'local'); 

define('CONFIG_PATH', ROOT . 'config' . DS); //directorio de los ficheros de configuracion

//carga de ficheros de configuracion
debug_simple("Cargando ficheros de configuracion<hr>");

foreach (glob(CONFIG_PATH . "*.php") as $filename) {
    debug_simple($filename);
    
    require_once $filename;
}

define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_METHOD', 'index');
define('DEFAULT_LAYOUT', 'default');


define('APP_NAME', 'pfc');
define('APP_SLOGAN', 'lorem ipsum...');
define('APP_COMPANY', 'tatooine Inc.');

define('SESSION_TIME', 15);
define('HASH_KEY', '573ca1f7efa62');

//estados usuario
define('USUARIO_ESTADO_ACTIVADO', 1);
define('USUARIO_ESTADO_NO_ACTIVADO', 0);

//roles usuario. Ojo, no es lo mismo que la tabla usuarios.
define('USUARIO_ROL_ADMIN', 3);
define('USUARIO_ROL_EDITOR', 2);
define('USUARIO_ROL_USUARIO', 1);
define('DEFAULT_ROLE', 3); //Ojo el 3 significa usuario en la tabla rol

define('REGISTROS_POR_PAGINA', 10);

define('REGISTROS_POR_PAGINA_LIST', REGISTROS_POR_PAGINA);
define('REGISTROS_POR_PAGINA_CARD', 10);
define('REGISTROS_POR_PAGINA_TABLE', 7);

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
}
else {
    define('LOG_LEVEL', LOG_NOTICE);
}


define('ACCION_EDITAR', 'editar');
define('ACCION_NUEVO', 'nuevo');
