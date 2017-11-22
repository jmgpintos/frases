<?php

class autorController extends Controller {

    private $_titulo = 'Autores';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('autor');
    }

    public function index() {
//        debug_fn(__METHOD__);
        $autor = $this->_model;

        $autores = $autor->getAllPaginated();

        $this->_view->autores = $autores;
        $this->_view->titulo = $this->_titulo . ' - Indice';
        $this->_view->tituloHTML = 'Autores';
        $this->_view->renderizar('index');
    }


}
