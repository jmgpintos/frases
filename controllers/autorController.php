<?php

class autorController extends Controller {

    private $_titulo = 'Autores';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('autor');

        $this->_titulo = $this->_titulo_app . $this->_titulo;
    }

    public function index() {
//        debug_fn(__METHOD__);
        $autor_model = $this->_model;

        $autores = $autor_model->getAllPaginated();
        $columnas = $autor_model->getColumnas($autores);

        $this->_view->assign('autores', $autores);
        $this->_view->assign('columnas', $columnas);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->assign('tituloHTML', 'Autores');
        $this->_view->renderizar('index');
    }

    public function view($id = 0) {
        $autor_model = $this->_model;
        $autor = $autor_model->getBYId($id);
        
        if (!$autor) {
            $this->_view->assign('_error', "No existe ningun autor con ese id ($id)");
            $this->_log->write(__METHOD__ .': '. "No existe ningun autor con ese id ($id)", LOG_WARNING);
        } else {
            $this->_view->assign('titulo', $this->_titulo_app . ' - ' . $autor['nombre']);
            $this->_view->assign('autor', $autor);
//            debug($autor);
        }
        
        $this->_view->renderizar('view');
    }

}
