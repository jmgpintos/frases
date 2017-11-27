<?php

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', realpath(dirname(__FILE__)) . DS); //ruta raiz de la aplicacion en el FS

require_once 'libs/helpers/debug_msg.php';
require_once ROOT. 'config/config.php';
require_once 'libs/helpers/autoloader.php';
require_once 'libs/helpers/helpers.php';

//debug($_GET['url'], 'url');
//debug(Hash::getHash('sha1', 'admin', HASH_KEY));exit;
Session::init();
try {
    Bootstrap::run(new Request());
} catch (Exception $e) {
    debug($e->getMessage(), 'ERROR');
}

//die;

//include_once LIB_PATH . 'helpers/pruebas/debug_msg.php';
//debug(get_defined_constants());
//debug(get_required_files());
?>