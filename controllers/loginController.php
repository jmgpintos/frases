<?php

class loginController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        Session::set('autenticado', true);
        Session::set('tiempo', time());
        
        Session::set('level', USUARIO_ROL_EDITOR);
        Session::set('var1', 'var1');
        Session::set('var2', 'var2');
        $this->redireccionar('login/mostrar');

//        $this->_view->renderizar('index');
    }
    
    public function mostrar(){

        debug(Session::getCurrentUserLevel(), 'Session::getCurrentUserLevel()');
        debug(Session::get("level"), 'Session::get("level")');
        debug(Session::getLevel(USUARIO_ROL_EDITOR), 'Session::getLevel("USUARIO_ROL_EDITOR)');
        
        debug(Session::get(),'Session::get()');
        
    }
    
    public function cerrar(){
        Session::destroy();
        $this->redireccionar('login/mostrar');
    }

}
