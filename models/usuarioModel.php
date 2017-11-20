<?php

class UsuarioModel extends Model{
    private $_table = 'usuario';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll($table = '') {
        return parent::getAll($this->_table);
//        $usuario = $this->_db->query("SELECT * FROM usuario");
        
        
//        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
