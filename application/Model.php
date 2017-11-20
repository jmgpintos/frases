<?php

class Model {
    protected $_db;
    
    public function __construct() {
        $this->_db = new Database();
    }
    
    //@TODO metodos generales (getAll, GetById, update, insert, delete, count,...)
}