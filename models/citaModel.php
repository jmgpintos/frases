<?php

class CitaModel extends Model {

    private $_table = 'cita';

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
        return parent::getAllPaginated($this->_table, [],1, REGISTROS_POR_PAGINA);
    }

    public function getById(String $table='', int $id) {
        if (!$table) {
            $table = $this->_table;
        }
        $this->_table = $table;
        return parent::getById($table, $id);
    }
    
    public function getRandom() {
        $total_records = parent::getCount($this->_table);
        $id = rand(1, $total_records);
        return parent::getById($this->_table, $id)[0];
    }

}
