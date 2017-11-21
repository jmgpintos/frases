<?php

/**
 * Description of Request
 * Procesa la peticion y provee de los valores de la peticion
 * @author Jose Manuel Garcia Pintos <jmgpintos@gmail.com>
 */
class Request {

    private $_controlador;
    private $_metodo;
    private $_argumentos;

    /**
     * 
     * @param type $url
     */
    public function __construct() {
//        debug_fn(__METHOD__, [$url]);
        
        if (isset($_GET['url'])) {
            $url = array_filter(explode("/", filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL)));

            $this->_controlador = strtolower(array_shift($url));
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumentos = $url;
        }

        if (!$this->_controlador) {
            $this->_controlador = DEFAULT_CONTROLLER;
        }

        if (!$this->_metodo) {
            $this->_metodo = 'index';
        }

        if (!isset($this->_argumentos)) {
            $this->_argumentos = array();
        }

//        debug($this->getControlador(), 'controlador', true);
//        debug($this->getMetodo(), 'metodo');
//        debug($this->getArgs(), 'argumentos');
    }

    public function getControlador() {
        return $this->_controlador;
    }

    public function getMetodo() {
        return $this->_metodo;
    }

    public function getArgs() {
        return $this->_argumentos;
    }

}
