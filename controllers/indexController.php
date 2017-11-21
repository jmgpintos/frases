<?php

class indexController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        debug_fn(__METHOD__, [$url]);
        $usuario = $this->loadModel('usuario');
//        debug($usuario, 'UUU');
//        debug($usuario->getAll(), 'usuario');
        $this->_view->usuarios = $usuario->getAll();
        $this->_view->titulo = 'Portada';
        $this->_view->renderizar('index');
    }

}
