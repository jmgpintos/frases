<?php

class CategoriaModel extends Model {

    private $_table = 'categoria';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {
        $categorias = parent::getAll($this->_table, $campos);

        for ($i = 0; $i < count($categorias); $i++) {
            $categorias[$i]['total'] = $this->_get_count_from_categoria($categorias[$i]['id']);
        }

        return $categorias;
    }

    public function getAllPaginated($first_record = 0, array $campos = []) {
        $categorias = parent::getAllPaginated($this->_table, $campos, $first_record, REGISTROS_POR_PAGINA);

        for ($i = 0; $i < count($categorias); $i++) {
            $categorias[$i]['total'] = $this->_get_count_from_categoria($categorias[$i]['id']);
        }

        return $categorias;
    }

    public function getById(int $id) {
        $categoria = parent::getById($this->_table, $id)[0];

        $frases = $this->_get_frases_from_categoria($categoria['id']);
        $categoria['total'] = count($frases);
        $categoria['frases'] = $frases;

        return $categoria;
    }

    private function _get_frases_from_categoria($categoria_id) {
        $table = parent::getTableName('cita');

        $sql = "SELECT * FROM $table "
                . "WHERE id_categoria = $categoria_id";

        return parent::getSQL($sql);
    }

    private function _get_count_from_categoria($categoria_id) {
        $table = parent::getTableName('cita');

        $sql = "SELECT COUNT(*) AS cuenta "
                . "FROM $table "
                . "WHERE id_categoria = $categoria_id";

        return parent::getSQL($sql)[0]['cuenta'];
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
