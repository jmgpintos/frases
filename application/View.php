<?php

require_once LIB_PATH . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php';

class View extends Smarty {

    private $_controlador;
    private $_js;

    public function __construct(Request $peticion) {
        parent::__construct();
        $this->_controlador = $peticion->getControlador();
        $this->_js = [];
    }

    public function renderizar($vista, $item = false) {
        //config smarty;
        $this->template_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS;
        $this->config_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'config' . DS;
        $this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
        $this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;

        $menu = $this->_getMenu();

        $_params = $this->_getLayoutParams($menu, $item, $this->_getJS());

        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl';
        debug($rutaView, 'rutaView');

        if (is_readable($rutaView)) {
            $this->assign('_contenido', $rutaView);
        } else {
            throw new Exception('Error de vista: ' . $rutaView);
        }

        $this->assign('_layoutParams', $_params);
        $this->display('template.tpl');
    }

    public function setJs(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                $this->_js[] = BASE_URL . 'views' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de js');
        }
    }

    private function _getJS() {
        $js = array();
        if (count($this->_js)) {
            $js = $this->_js;
        }
        return $js;
    }

    private function _getLayoutParams($menu, $item, $js) {
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu,
            'item' => $item,
            'js' => $js,
            'root' => BASE_URL,
            'configs' => array(
                'app_name' => APP_NAME,
                'app_company' => APP_COMPANY,
                'app_slogan' => APP_SLOGAN
            )
        );
//        debug($_layoutParams, '$_layoutParams');
        return $_layoutParams;
    }

    private function _getMenu() {
        $menu = [
            ['id' => 'inicio', 'titulo' => 'inicio', 'enlace' => BASE_URL],
            ['id' => 'citas', 'titulo' => 'Citas', 'enlace' => BASE_URL . 'cita'],
            ['id' => 'categorias', 'titulo' => 'Categor&iacute;as', 'enlace' => BASE_URL . 'categoria'],
            ['id' => 'autores', 'titulo' => 'Autores', 'enlace' => BASE_URL . 'autor'],
            ['id' => 'usuarios', 'titulo' => 'Usuarios', 'enlace' => BASE_URL . 'usuario']
        ];

        $menu = $this->_getMenuAutenticado($menu);

//        debug($menu, 'menu');
        return $menu;
    }

    public function _getMenuAutenticado($menu) {
        if (Session::estaAutenticado()) {
            $menu[] = ['id' => 'login', 'titulo' => 'Cerrar Sesi&oacute;n', 'enlace' => BASE_URL . 'login/cerrar'];
            if (Session::esAdmin()) {
                $menu[] = ['id' => 'registro', 'titulo' => 'Registro', 'enlace' => BASE_URL . 'registro'];
            }
        } else {
            $menu[] = ['id' => 'login', 'titulo' => 'Iniciar Sesi&oacute;n', 'enlace' => BASE_URL . 'login'];
        }

        return $menu;
    }

}
