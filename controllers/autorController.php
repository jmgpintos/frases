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
        $autor_model = $this->_model;

        $autores = $autor_model->getAllPaginated();

        $this->_view->assign('autores', $autores);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->assign('tituloHTML', 'Autores');
        $this->_view->renderizar('index');
    }

    public function view($id) {
        $autor_model = $this->_model;
        $autor = $autor_model->getBYId($id);
        if (!$autor) {
            $this->_view->assign('_error',"No existe ningun autor con ese id ($id)");
        } else {
            $this->_view->assign('autor',$autor);
//            debug($autor);
        }
        $this->_view->renderizar('view');
    }

}
