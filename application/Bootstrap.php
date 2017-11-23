<?php

/**
 * Procesa las llamadas a controladores y metodos
 */
class Bootstrap {

    public static function run(Request $peticion) {
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        debug($rutaControlador, ' rutaControlador');

        $metodo = $peticion->getMetodo();
        debug($metodo, 'Metodo');
        $args = $peticion->getArgs();

        if (is_readable($rutaControlador)) {
//            debug($rutaControlador,'rutaControlador');
//            debug($controller,Controller);
            require_once $rutaControlador;

            $controller = new $controller;

            if (is_callable(array($controller, $metodo))) {
                $metodo = $peticion->getMetodo();
                ;
            } else {
                $metodo = 'index';
            }
            self::_call_function($args, $controller, $metodo);

//            $view = new View($controller, $metodo);
        } else {
            throw new Exception('No encontrado: ' . $rutaControlador);
        }
    }

    private function _call_function(array $args, Controller $controller, String $metodo) {

        if (isset($args)) {
            call_user_func_array(array($controller, $metodo), $args);
        } else {
            call_user_func(array($controller, $metodo));
        }
    }

}
