<?php

class autorController extends Controller {

    private $_titulo = 'Autores';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('autor');

        $this->_titulo = $this->_titulo_app . $this->_titulo;
    }

    public function index($pagina = 1) {
//        debug_fn(__METHOD__);
        $autor_model = $this->_model;

        $paginador = new Paginador();
        if (!$this->filtrarInt($pagina)) {
            $pagina = 0;
        }

        $autores = $paginador->paginar($autor_model->getAllPaginated($pagina), $autor_model->getCount('autor'), $pagina);

        $columnas = $autor_model->getColumnas($autores);

        $this->_view->assign('paginacion', $paginador->getView('paginacion', 'autor/index'));
        $this->_view->assign('autores', $autores);
        $this->_view->assign('columnas', $columnas);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->assign('tituloHTML', 'Autores');
        $this->_view->renderizar('index', 'autores');
    }

    public function view($id = 0) {
//        Session::acceso(USUARIO_ROL_EDITOR);//prueba acceso
        $autor_model = $this->_model;
        $autor = $autor_model->getBYId($id);

        if (!$autor) {
            $this->_view->assign('_error', "No existe ningun autor con ese id ($id)");
            $this->_log->write(__METHOD__ . ': ' . "No existe ningun autor con ese id ($id)", LOG_WARNING);
        } else {
            $this->_view->assign('titulo', $this->_titulo_app . ' - ' . $autor['nombre']);
            $this->_view->assign('autor', $autor);
//            debug($autor);
        }

        $this->_view->renderizar('view', 'autores');
    }

}
