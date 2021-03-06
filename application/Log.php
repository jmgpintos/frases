<?php

define('DIR_PATH', dirname(__FILE__));
define('DIR_LOGS', DIR_PATH . "/logs/");

//@TODO controlar creacion y permisos de fichero log
class Log {

    /**
     * 
     * @var String Nombre del fichero de log
     */
    private $_filename;

    public function __construct($_filename = 'log.txt') {
//        debug_fn(__METHOD__, [$url]);
        $this->_filename = DIR_LOGS . $_filename;
//        debug($this->_filename);
    }

    /**
     * Agrega líneas al archivo de log
     * 
     * @param type $message
     * @param type $level Nivel mínimo para guardar los mensajes
     */
    public function write($message, $level = LOG_DEBUG) {
//        debug_fn(__METHOD__);
//        debug($message);
        if ($level <= LOG_LEVEL) {
            if (Session::estaAutenticado()) {
                $usuario = Session::get('id_usuario');
            } else {
                $usuario = 'No autenticado';
            }
//        debug($this->_filename,'log_filename');
            $handle = fopen($this->_filename, 'a+');
            debug($handle, 'handle');
            fwrite($handle, $this->_getLevelString($level)
                    . date('Y-m-d G:i:s')
                    . ' - Usuario: ' . $usuario . ' - '
                    . $message . "\n");

            fclose($handle);
        }
    }

    private function _getLevelString(int $level) {

        $log_level = [
            0 => 'EMERG   ',
            1 => 'ALERT   ',
            2 => 'CRIT    ',
            3 => 'ERR     ',
            4 => 'WARNING ',
            5 => 'NOTICE  ',
            6 => 'INFO    ',
            7 => 'DEBUG   ',
        ];

        return $log_level[$level];
    }

}
