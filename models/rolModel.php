<?php

class RolModel extends Model {

    private $_table = 'rol';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {
        $roles = parent::getAll($this->_table, $campos);

        for ($i = 0; $i < count($roles); $i++) {
            $roles[$i]['total'] = $this->_get_count_from_rol($roles[$i]['id']);
        }

        return $roles;
    }

    public function getAllPaginated($first_record = 0,array $campos = []) {
        $roles = parent::getAllPaginated($this->_table, $campos, $first_record, REGISTROS_POR_PAGINA);

        for ($i = 0; $i < count($roles); $i++) {
            $roles[$i]['total'] = $this->_get_count_from_rol($roles[$i]['id']);
        }

        return $roles;
    }

    public function getById(int $id) {
        $rol = parent::getById($this->_table, $id)[0];

        $usuarios = $this->_get_users_from_rol($rol['id']);
        $rol['num_usuarios'] = count($usuarios);
        $rol['usuarios'] = $usuarios;

        return $rol;
    }

    private function _get_users_from_rol($rol_id) {
        $table = parent::getTableName('usuario');

        $sql = "SELECT * FROM $table "
                . "WHERE rol_id = $rol_id";

        return parent::getSQL($sql);
    }

    private function _get_count_from_rol($rol_id) {
        $table = parent::getTableName('usuario');

        $sql = "SELECT COUNT(*) AS total FROM $table "
                . "WHERE rol_id= $rol_id";

        return parent::getSQL($sql)[0]['total'];
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
