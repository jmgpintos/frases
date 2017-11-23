<?php

class citaController extends Controller {

    private $_titulo = 'Citas';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('cita');
    }

    public function index() {
        debug_fn(__METHOD__);
        $cita = $this->_model;

        $frases = $cita->getAllPaginated();
        $this->_view->assign('frases',  $frases);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->renderizar('index');
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
