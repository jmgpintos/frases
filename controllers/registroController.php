<?php

class registroController extends Controller {

    private $_registro;

    public function __construct() {
        parent::__construct();
        $this->_registro = $this->loadModel('registro');
    }

    public function index() {
        Session::acceso(USUARIO_ROL_ADMIN);

        $this->_view->assign('titulo', 'Registro');

        if ($this->getInt('enviar') == 1) {
            $this->_view->assign('datos', $_POST);

            if (!$this->_validar()) {
                $this->ponerError($this->_error);
                $this->_view->renderizar('index', 'registro');
                exit;
            }
            $this->_registrarUsuario();
            if ($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))) {
                $this->ponerMensaje("Registro completado");
                $this->_view->assign('datos', false);
            } else {
                $this->ponerError("No se pudo crear el usuario");
            }
            $this->_view->renderizar('index', 'registro');
            exit;
        }

        debug("NO ENVIAR");
        $this->_view->renderizar('index', 'registro');
    }

    public function _validar() {
        $this->_error = false;
//        debug($_POST);

//        if (!$this->getSql('apellidos')) {
//            $this->_error = "Debe introducir apellidos";
//        } else if (!$this->getSql('nombre')) {
//            $this->_error = "Debe introducir un nombre";
//        } else

        if (!$this->getSql('usuario')) {
            $this->_error = "Debe introducir un nombre de usuario";
        } else if ($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))) {
            $this->_error = "El usuario " . $this->getAlphaNum('usuario') . " ya existe";
        } else if ($this->_registro->verificarEmail($this->getPostParam('email'))) {
            $this->_error = "Esta direcci&oacute;n de correo ya est&aacute; registrada";
        } else if (!$this->validarEmail($this->getPostParam('email'))) {
            $this->_error = "Debe introducir un mail v&aacutelido";
        } else if (!$this->getSql('password')) {
            $this->_error = "Debe introducir una contraseña";
        } else if ($this->getPostParam('password') != $this->getPostParam('confirmar')) {
            $this->_error = "Las contraseñas no coinciden";
        }

        return !$this->_error;
    }

    public function _registrarUsuario() {
        $data = [
            'apellidos' => $this->getAlphaNum('apellidos'),
            'nombre' => $this->getAlphaNum('nombre'),
            'usuario' => $this->getAlphaNum('usuario'),
            'password' => $this->getSql('password'),
            'email' => $this->getPostParam('email')
        ];
        $this->_registro->registrarUsuario($data);
    }

}
