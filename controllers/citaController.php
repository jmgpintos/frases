<?php

class citaController extends Controller {

    private $_titulo = 'Citas';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('cita');
    }

    public function index($pagina = false) {


//        debug_fn(__METHOD__);
        $cita_model = $this->_model;
        $paginador = new Paginador();
        $registros_por_pagina = 20;

        if (!$this->filtrarInt($pagina)) {
            $pagina = 0;
        }

        $frases = $paginador->paginar(
                $cita_model->getAllPaginated($pagina, [], $registros_por_pagina), $cita_model->getCount('cita'), $pagina, $registros_por_pagina
        );

        $this->_view->assign('paginacion', $paginador->getView('paginacion', 'cita/index'));
        $this->_view->assign('frases', $frases);
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
