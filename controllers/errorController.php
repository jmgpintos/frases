<?php

class errorController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_view->assign('titulo', 'Error');
        $this->_view->assign('mensaje', $this->_getError());
        $this->_view->renderizar('index');
    }
    
    public function access($codigo) {
        $this->_view->assign('titulo', 'Error');
        $this->_view->assign('mensaje', $this->_getError($codigo));
        $this->_view->renderizar('access');
        
    }

    private function _getError(int $codigo = NULL) {
        if ($codigo) {
            $codigo = $this->filtrarInt($codigo);
        } else {
            $codigo = 'default';
        }

        $error['default'] = 'Ha ocurrido un error y la p&aacute;gina no puede mostrarse';
        $error['5050'] = 'Acceso restringido';
        $error['8080'] = 'Tiempo de sesion agotado';

        if (array_key_exists($codigo, $error)) {
            return $error[$codigo];
        } else {
            return $error['default'];
        }
    }

}
