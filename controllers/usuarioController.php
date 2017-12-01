<?php

class usuarioController extends Controller {

    private $_titulo = 'Usuarios';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('usuario');
    }

    public function index() {
        debug_fn(__METHOD__);
        $model = $this->_model;

        $usuarios = $model->getAllPaginated();
//        debug($usuarios);

        $this->_view->assign('usuarios', $usuarios);
        $this->_view->assign('titulo', $this->_titulo . ' - Usuarios');
        $this->_view->assign('tituloHTML', 'Usuarios');
        $this->_view->renderizar('index', 'usuarios');
    }

}
