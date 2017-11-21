<?php

class UsuarioModel extends Model {

    private $_table = 'usuario';

    public function __construct() {
        parent::__construct();
    }

    public function getAll($table = NULL) {
        if (!$table) {
            $table = $this->_table;
        }
        
        return parent::getAll($table);
    }

    public function getAllPaginated($table = '') {
        if (!$table) {
            $table = $this->_table;
        }
        $this->_table = $table;
        $this->_table = 'cita';
        return parent::getAllPaginated($this->_table, 1, REGISTROS_POR_PAGINA);
    }

}
