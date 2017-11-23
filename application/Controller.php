<?php

abstract class Controller {

    protected $_view;

    public function __construct() {
        $this->_view = new View(new Request());
    }

    abstract public function index();

    protected function loadModel($modelo) {
//        debug_fn(__METHOD__, [$url]);
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

        if (is_readable($rutaModelo)) {
            require_once $rutaModelo;
            $modelo = new $modelo;
            debug($rutaModelo, 'rutaModelo');
            return $modelo;
        } else {
            throw new Exception('Error de modelo: ' . $rutaModelo);
        }
    }

}
