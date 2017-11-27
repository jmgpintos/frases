<?php

class loginModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUsuario($usuario, $password) {
        $sql = "SELECT * FROM usuario "
                . "WHERE usuario = '$usuario' "
                . "AND password = '" . Hash::getHash('sha1', $password, HASH_KEY) . "'";
        $this->_log->write($sql);
        $datos = $this->_db->query($sql);
        return $datos->fetch(PDO::FETCH_ASSOC);
    }

    private function _getNameRolById($id_rol) {
        $sql = "SELECT nombre FROM rol WHERE id=$id_rol";
        $this->_log->write($sql);
        $datos = $this->_db->query($sql);
        $datos = $datos->fetch(PDO::FETCH_ASSOC);
        return $datos['nombre'];
    }

    public function getRolById($id_rol) {
        $nombre_rol = $this->_getNameRolById($id_rol);
        if ($nombre_rol == 'admin') {
            return USUARIO_ROL_ADMIN;
        } else if ($nombre_rol == 'editor') {
            return USUARIO_ROL_EDITOR;
        } else {
            throw new Exception('Error: rol incorrecto');
        }
    }

}
