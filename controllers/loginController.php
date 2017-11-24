<?php

class loginController extends Controller {

    private $_login;

    public function __construct() {
        parent::__construct();
        $this->_login = $this->loadmodel('login');
    }

    public function index() {
        $this->_view->assign('titulo', 'Iniciar sesi&oacute;n');
        if ($this->getInt('enviar') == 1) {
            debug('ENVIAR');
            $this->_view->assign('datos', $_POST);

            if (!$this->getAlphaNum('usuario')) {
            debug('usuario');
                $this->_view->assign('_error', 'Debe introducir un nombre de usuario');
                $this->_view->renderizar('index', 'login');
                exit;
            }
            if (!$this->getSql('password')) {
            debug('password');
                $this->_view->assign('_error', 'Debe introducir su password');
                $this->_view->renderizar('index', 'login');
                exit;
            }
            
            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('usuario'), $this->getSql('password')
            );

            if (!$row) {
                $this->_view->assign('_error', 'usuario y/o password incorrectos');
                $this->_view->renderizar('index', 'login');
                exit;
            }

//            if($row['estado'] == USUARIO_ESTADO_NO_ACTIVADO){
//                $this->_view->assign('_error', 'Este usuario no esta habilitado');
//                $this->_view->renderizar('index', 'login');
//                exit;                
//            }

            Session::set('autenticado', true);
            Session::set('tiempo', time());
            Session::set('level',  $this->_login->getRolById($row['rol_id'])); 
            Session::set('id_usuario', $row['id']);
            Session::set('username', $row['usuario']);
////            $this->_view->assign('usuario', $row);
//            debug($row);
            $this->redireccionar();

        }
            debug(Session::get(),'Session');

        $this->_view->renderizar('index', 'login');

//        $this->_view->renderizar('index');
    }

    public function cerrar() {
        Session::destroy();
        $this->redireccionar();
    }

}
