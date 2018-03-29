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
        $this->_view->renderizar('index', 'citas');
    }

    public function view($id_cita) {

        if (!$this->filtrarInt($id_cita)) {
            $id_cita = 0;
        }

        $cita = $this->_model->getById($id_cita);
        $this->_view->assign('cita', $cita);
        $this->_view->renderizar('view', 'citas');
        debug($cita);
    }

    public function buscar($pagina = 1) {
        //@TODO hacer vista propia
        //@TODO ampliar busqueda a frase y autor

        $buscar = $this->getPostParam('cadena-busqueda');

        if (!$buscar) {
            $buscar = Session::get('busqueda');
        } else {
            Session::set('busqueda', $buscar);
        }

        $textos_a_buscar = $this->_getTextosBusqueda($buscar);

        $paginador = new Paginador();
        $registros_por_pagina = 20;
        $busqueda = $this->_model->getBusqueda($textos_a_buscar, $pagina, $registros_por_pagina);

        $frases = $paginador->paginar($busqueda['rs'], $busqueda['cuenta'], $pagina, $registros_por_pagina);

        $this->_view->assign('paginacion', $paginador->getView('paginacion', 'cita/buscar'));
        $this->_view->assign('frases', $frases);
        $this->_view->assign('cuenta', $cuenta);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        
        debug($busqueda['cuenta'], 'cuenta');

        $this->_view->renderizar('index', 'citas');
    }

    public function random() {
        $cita = $this->_model;

        $frase = $cita->getRandom();

        $this->_view->assign('frase', $frase);
        $this->_view->assign('titulo', $this->_titulo . ' - Cita aleatoria');
        $this->_view->renderizar('random', 'citas');
    }

    public function quote_of_the_day() {
        
    }

    private function _getTextosBusqueda($buscar) {
        $etiquetas = explode(' ', trim($buscar));
        for ($i = 0; $i < count($etiquetas); $i++) {
            $etiquetas[$i] = $etiquetas[$i] . ".*";
        }
        return $etiquetas;
    }

}
