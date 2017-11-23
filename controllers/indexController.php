<?php

class indexController extends Controller {
    private $_prueba = 'usuario';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        debug_fn(__METHOD__, [$url]);
        $usuario = $this->loadModel($this->_prueba);
//        debug($usuario, 'UUU');
//        debug($usuario->getAll(), 'usuario');
//        $this->_view->usuarios = $usuario->getAllPaginated();
        $id = rand(1,$usuario->getCount($this->_prueba));
        $this->_view->assign('usuarios', $usuario->getById($id));
        $this->_view->assign('titulo', 'Portada');
        debug($id, 'random ID');
        $this->_view->renderizar('index');
    }

}
