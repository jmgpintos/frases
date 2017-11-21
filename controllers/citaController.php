<?php

class citaController extends Controller {

    private $_titulo = 'Citas';

    public function __construct() {
        parent::__construct();
    }

    public function index() {
//        debug_fn(__METHOD__, [$url]);
        $cita = $this->loadModel('cita');

        $frases = $cita->getAllPaginated();
//        debug($frases[0]);
        for ($index = 0; $index < count($frases); $index++) {
            $frases[$index] = $this->_extend($cita, $frases[$index]);
        }
//        debug($frases[0]);

        $this->_view->frases = $frases;
        $this->_view->titulo = $this->_titulo . ' - Indice';
        $this->_view->renderizar('index');
    }

    public function random() {
//        debug_fn(__METHOD__, [$url]);
        $cita = $this->loadModel('cita');

        $frase = $cita->getRandom();
//        debug($frase,1);
        $frase = $this->_extend($cita, $frase);
        debug($frase,2);

        $this->_view->frases = $frases;
        $this->_view->titulo = $this->_titulo . ' - Indice';
        $this->_view->renderizar('index');
    }

    /**
     * 
     * @param type $cita
     * @param type $frases
     * @return type
     */
    private function _extend($cita, $frase) {
        //@TODO recuperar etiquetas
//        debug($frase, __METHOD__);
        $id_autor = $frase['id_autor'];
        $autor = $cita->getById('autor', $id_autor)[0];
        $id_categoria = $frase['id_categoria'];
        $categoria = $cita->getById('categoria', $id_categoria)[0];
        $frase['autor'] = $autor;
        $frase['categoria'] = $categoria;

        return $frase;
    }

}
