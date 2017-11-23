<?php

class categoriaController extends Controller {

    private $_titulo = 'Categor&iacute;as';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('categoria');
    }

    public function index() {
        debug_fn(__METHOD__);
        $categoria_model = $this->_model;

        $categorias = $categoria_model->getAllPaginated();
        $columnas = $categoria_model->getColumnas($categorias);
        
        $this->_view->assign('categorias',  $categorias);
        $this->_view->assign('columnas',  $columnas);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->renderizar('index');
        debug($columnas, 'columnas');
        debug($categorias, 'categorias');
    }

    public function random() {
        $cita = $this->_model;

        $frase = $cita->getRandom();

        $this->_view->assign('frase', $frase);
        $this->_view->assign('titulo', $this->_titulo . ' - Cita aleatoria');
        $this->_view->renderizar('random');
    }
    
    public function quote_of_the_day() {
        
    }

}
