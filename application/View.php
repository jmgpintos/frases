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
        $menu = array(
            array(
                'id' => 'inicio',
                'titulo' => 'inicio',
                'enlace' => BASE_URL
            ),
            array(
                'id' => 'hola',
                'titulo' => 'Hola',
                'enlace' => BASE_URL . 'hola'
            )
        );
//        debug($menu, 'menu');
        return $menu;
    }

}
