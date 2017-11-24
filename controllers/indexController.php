<?php

class indexController extends Controller {
    private $_model = 'cita';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        debug_fn(__METHOD__, [$url]);
        $cita_model = $this->loadModel($this->_model);
        
        $cita_random = $cita_model->getRandom();
        
        $this->_view->assign('frase', $cita_random);
        $this->_view->assign('titulo', 'Portada');
        $this->_view->renderizar('index');
    }

}
