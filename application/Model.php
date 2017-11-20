<?php

class Model {
    protected $_db;
    
    public function __construct() {
        $this->_db = new Database();
    }
    
    //@TODO metodos generales (getAll, GetById, update, insert, delete, count,...)
    protected function getAll($table) {
        $query = $this->_db->query("SELECT * FROM $table");
        
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}