<?php

class UsuarioModel extends Model {

    private $_table = 'usuario';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {
        $usuarios = parent::getAll($this->_table, $campos);

        for ($i = 0; $i < count($usuarios); $i++) {
            $usuarios[$i] = $this->_extender($usuarios[$i]);
        }

        return $usuarios;
    }

    public function getAllPaginated($first_record = 0, array $campos = []) {
        $usuarios = parent::getAllPaginated($this->_table, $campos, $first_record, REGISTROS_POR_PAGINA);
        for ($i = 0; $i < count($usuarios); $i++) {
            $usuarios[$i] = $this->_extender($usuarios[$i]);
        }

        return $usuarios;
    }

    public function getById(int $id) {
        $usuario = parent::getById($this->_table, $id)[0];
        $usuario = $this->_extender($usuario);
        return $usuario;
    }

    private function _extender($usuario) {
        if (isset($usuario['rol_id'])) {
            $rol = parent::getById('rol', $usuario['rol_id'])[0];
            $usuario['rol'] = $rol['nombre'];
        }
        return $usuario;
    }

    public function insertar(array $campos) {
        return parent::insertarRegistro($this->_table, $campos); //devuelve lastId;
    }

    public function editar($index, array $campos) {
        return parent::editarRegistro($this->_table, $index, $campos); //devuelve resultado de ejecucion de update
    }

    public function eliminarRegistro($index) {
        return parent::eliminarRegistro($this->_table, $index); //devuelve el registro borrado o false si ha habido error
    }

}
