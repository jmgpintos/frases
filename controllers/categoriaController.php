<?php

class categoriaController extends Controller {

    private $_titulo = 'Categor&iacute;as';
    private $_model;

    public function __construct() {
        parent::__construct();
        $this->_model = $this->loadModel('categoria');
    }

    public function index($pagina = 1) {
        $categoria_model = $this->_model;
        $paginador = new Paginador();
        if (!$this->filtrarInt($pagina)) {
            $pagina = 0;
        }

        $categorias = $paginador->paginar($categoria_model->getAllPaginated($pagina), $categoria_model->getCount('categoria'), $pagina);
//        $categorias = $categoria_model->getAllPaginated();
        $columnas = $categoria_model->getColumnas($categorias);

        $this->_view->assign('categorias', $categorias);
        $this->_view->assign('paginacion', $paginador->getView('paginacion', 'categoria/index'));
        $this->_view->assign('columnas', $columnas);
        $this->_view->assign('titulo', $this->_titulo . ' - Indice');
        $this->_view->assign('tituloHTML', $this->_titulo);
        $this->_view->renderizar('index', 'categorias');
    }

    public function lista() {

        $lista_categorias = $this->_model->getAll(['nombre']);
        $break = ceil((count($lista_categorias) / 3));

        $this->_view->assign('lista_categorias', $lista_categorias);
        $this->_view->assign('break', $break);
        $this->_view->renderizar('lista', 'categorias');
    }

    public function ver($id_categoria = 0, $pagina = 0) {
        $paginador = new Paginador();
        if (!$this->filtrarInt($id_categoria)) {
            $this->ponerError("Categoria no especificada");
            $this->ponerMensaje("Categoria no especificada");
        } else {
            if (!$this->filtrarInt($pagina)) {
                $pagina = 1;
            }

            $categoria = $this->_model->getById($id_categoria);

            $nombre_categoria = $categoria['nombre'];
            $count = $categoria['total'];
            $frases = $categoria['frases'];

            $paginador = new Paginador();
            $frases_parcial = $this->_getFrasesParcial($frases, $pagina);
            $frases_a_mostrar = $paginador->paginar($frases_parcial, $count, $pagina);

            $this->_view->assign('titulo', $this->_titulo);
            $this->_view->assign('frases', $frases_a_mostrar);
            $this->_view->assign('nombre_categoria', $nombre_categoria);
            $this->_view->assign('paginacion', $paginador->getView('paginacion', 'categoria/ver/' . $id_categoria));
        }

        $this->_view->renderizar('frases', 'categorias');
    }

    public function random() {
        $cita = $this->_model;

        $frase = $cita->getRandom();

        $this->_view->assign('frase', $frase);
        $this->_view->assign('titulo', $this->_titulo . ' - Cita aleatoria');
        $this->_view->renderizar('random', 'categorias');
    }

    public function quote_of_the_day() {
        
    }

    private function _getFrasesParcial($frases, $pagina) {
        $frases_parcial = array_slice($frases, ($pagina - 1) * REGISTROS_POR_PAGINA, REGISTROS_POR_PAGINA);
        $autor_model = $this->loadModel('autor');
        for ($i = 0; $i < count($frases_parcial); $i++) {
            $frases_parcial[$i]['autor'] = $autor_model->getById($frases_parcial[$i]['id_autor'], false);
        }
        return $frases_parcial;
    }

}
