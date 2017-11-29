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

            $this->getLibrary('class.phpmailer'); //Hay que comprobar si existe esta libreria antes de registrar el usuario
            $this->_registrarUsuario();
            $this->_enviarCorreo();

            $this->ponerMensaje("Registro completado");
            $this->_view->assign('datos', false);
        }


        debug("NO ENVIAR");
        $this->_view->renderizar('index', 'registro');
    }

    public function activar($id, $codigo) {
        if (!$this->filtrarInt($id) || !$this->filtrarInt($codigo)) {
            $this->ponerError("Esta cuenta no existe");
            $this->_view->renderizar('activar', 'registro');
            exit;
        }
        $usuario = $this->_registro->getUsuario(
                $this->filtrarInt($id), $this->filtrarInt($codigo)
        );


        if (!$usuario) {
            $this->ponerError("Esta cuenta no existe");
            $this->_view->renderizar('activar', 'registro');
            exit;
        }

        if ($usuario['estado'] == USUARIO_ESTADO_ACTIVADO) {
            $this->ponerError("Esta cuenta ya ha sido activada");
            $this->_view->renderizar('activar', 'registro');
            exit;
        }

        $this->_registro->activarUsuario($this->filtrarInt($id));
        $usuario = $this->_registro->getUsuario(
                $this->filtrarInt($id), $this->filtrarInt($codigo)
        );
        if ($usuario['estado'] == USUARIO_ESTADO_NO_ACTIVADO) {
            $this->ponerError("Error al activar la cuenta, por favor intente m&aacute;s tarde");
            $this->_view->renderizar('activar', 'registro');
            exit;
        }
        $this->ponerMensaje('Su cuenta ha sido activada correctamente');
        $this->_view->renderizar('activar', 'registro');
    }

    private function _validar() {
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

    private function _registrarUsuario() {
        $data = [
            'apellidos' => $this->getSql('apellidos'),
            'nombre' => $this->getSql('nombre'),
            'usuario' => $this->getAlphaNum('usuario'),
            'password' => $this->getSql('password'),
            'email' => $this->getPostParam('email')
        ];
        $this->_registro->registrarUsuario($data);
    }

    private function _enviarCorreo() {

        $usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
        if (!$usuario) {
            $this->ponerError("No se pudo crear el usuario");
            $this->_view->renderizar('index', 'registro');
            exit;
        }
        $mail = $this->_getMailProperties($usuario);
        $mail->send();
    }

    private function _getMailProperties($usuario) {
        $mail = new PHPMailer();

        $mail->From = BASE_URL;
        $mail->FromName = 'Frases c&eacute;lebres';
        $mail->Subject = "Activaci&oacute;n de cuenta de usuario";
        $mail->Body = "Hola <strong>" . $this->getSql('nombre') . "</strong>,"
                . "<p>Se ha registrado en " . BASE_URL . " para activar su cuenta "
                . "haga click en el siguiente enlace: <br>"
                . "<a href='" . BASE_URL . "registro/activar/"
                . $usuario['id'] . "/" . $usuario['codigo'] . "'>"
                . BASE_URL . "registro/activar"
                . $usuario['id'] . "/" . $usuario['codigo'] . "</a>";
        $mail->AltBody = "Su servidor de correo no soporta HTML";
        $mail->addAddress($this->getPostParam('email'));

        return $mail;
    }

}
