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

        $this->_view->items = $usuarios;
        $this->_view->titulo = $this->_titulo . ' - Usuarios';
        $this->_view->tituloHTML = 'Usuarios';
        $this->_view->renderizar('index');
    }

    public function random() {
        $cita = $this->_model;

        $frase = $cita->getRandom();

        $this->_view->frase = $frase;
        $this->_view->titulo = $this->_titulo . ' - Cita aleatoria';
        $this->_view->renderizar('random');
    }
    
    public function quote_of_the_day() {
        
    }

}
