<?php

class indexController extends Controller {
    private $_model = 'cita';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        debug_fn(__METHOD__, [$url]);
        $cita_model = $this->loadModel($this->_model);
        $categoria_model = $this->loadModel('categoria');
        
        $cita_random = $cita_model->getRandom();
        $lista_categorias = $categoria_model->getAll(['nombre']);
        $break = ceil((count($lista_categorias)/3));
        
        $this->_view->assign('frase', $cita_random);
        $this->_view->assign('lista_categorias', $lista_categorias);
        $this->_view->assign('break', $break);
        
        $this->_view->assign('titulo', 'Portada');
        
        $this->_view->renderizar('index', 'inicio');
    }

}
