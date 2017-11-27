<?php

abstract class Controller {

    protected $_view;
    protected $_titulo_app = 'FRASES';
    protected $_log;
    protected $_error;
    protected $_message;

    public function __construct() {
        $this->_view = new View(new Request());
        $this->_log = new Log();
    }

    abstract public function index();

    protected function loadModel($modelo) {
//        debug_fn(__METHOD__, [$url]);
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

        if (is_readable($rutaModelo)) {
            require_once $rutaModelo;
            $modelo = new $modelo;
            debug($rutaModelo, 'rutaModelo');
            return $modelo;
        } else {
            throw new Exception('Error de modelo: ' . $rutaModelo);
        }
    }

    /**
     * Filtra el texto que viene por POST
     * @param type $clave
     */
    protected function getTexto($clave) {
        if (isset($_POST[$clave]) && !empty($_POST['clave'])) {
            $_POST['clave'] = htmlspecialchars($_POST['clave'], ENT_QUOTES);
            return $_POST['clave'];
        }

        return '';
    }

    /**
     * Filtra los numeros que vienen por POST
     * @param type $clave
     */
    protected function getInt($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            debug('TEST');
            $_POST['clave'] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST['clave'];
        }

        return 0;
    }

    protected function redireccionar($ruta = false) {
        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit;
        } else {
            header('location:' . BASE_URL);
            exit;
        }
    }

    /**
     * Filtra los numeros que vienen por GET
     * @param type $int
     */
    protected function filtrarInt($int) {
        $int = (int) $int;
        if (is_int($int)) {
            return $int;
        } else {
            return 0;
        }
    }

    protected function getPostParam($clave) {
        if (isset($_POST[$clave])) {
            return $_POST[$clave];
        }
    }

    protected function getSql($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = strip_tags($_POST[$clave]);

//            if (!get_magic_quotes_gpc()) {
//                $_POST[$clave] = mysqli_escape_string($_POST[$clave]);
//            }

            return trim($_POST[$clave]);
        }
    }

    protected function getAlphaNum($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }

    public function validarEmail($email) {
        debug_fn(__METHOD__, [$email]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    protected function ponerError($err) {
        $this->_view->assign('_error', $err);
    }

    protected function ponerMensaje($msg) {
        $this->_view->assign('_mensaje', $msg);
    }

}
