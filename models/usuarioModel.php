<?php

class UsuarioModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getUsuarios() {
        $usuario = $this->_db->query("SELECT * FROM usuario");
        
        
        return $usuario->fetchAll(PDO::FETCH_ASSOC);
    }
}
