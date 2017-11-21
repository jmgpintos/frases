<?php

spl_autoload_register('__autoload');

function __autoload($class_name) {

    debug_fn(__FUNCTION__, ['$class_name' => $class_name]);
    //class directories
    $directories = CLASS_DIRS;
//    debug($directories,'directories');

    //for each directory
    $file_exists = FALSE;
    foreach ($directories as $directory) {
//        debug($directory, 'directory');
        //see if the file exists
        if (file_exists($directory . $class_name . '.php')) {
            try {
                $file_exists = TRUE;
                require_once($directory . $class_name . '.php');
                debug_msg("Cargando " . $directory . $class_name . '.php');
                return;
            } catch (Exception $exc) {
                debug_msg($exc->getTraceAsString());
            }
        }
        if (!$file_exists) {
            debug_msg(__FUNCTION__ . ": " . $class_name . '.php' . ": Fichero no existe");
        }
    }
}
