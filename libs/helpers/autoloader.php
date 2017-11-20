<?php

spl_autoload_register('__autoload');

function __autoload($class_name) {

//    debug_fn(__FUNCTION__, ['$class_name' => $class_name]);
    //class directories
    $directorys = CLASS_DIRS;

    //for each directory
    $file_exists = FALSE;
    foreach ($directorys as $directory) {
        //see if the file exists
        if (file_exists($directory . $class_name . '.php')) {
            try {
                $file_exists = TRUE;
                require_once($directory . $class_name . '.php');
//                debug_msg("Cargando " . $directory . $class_name . '.php');
                return;
            } catch (Exception $exc) {
                debug_msg($exc->getTraceAsString());
            }
        }
    }
    if (!$file_exists) {
        debug_msg(__FUNCTION__ . ": " . $class_name . '.php' . ": Fichero no existe");
    }
}
