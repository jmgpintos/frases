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
define('DEFAULT_LAYOUT', 'default');


define('APP_NAME', 'pfc');
define('APP_SLOGAN', 'lorem ipsum...');
define('APP_COMPANY', 'tatooine Inc.');

