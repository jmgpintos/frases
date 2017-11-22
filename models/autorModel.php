<?php

class AutorModel extends Model {

    private $_table = 'autor';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {

        $autores = parent::getAll($this->_table, $campos);
        for ($i = 0; $i < count($autores); $i++) {
            $autores[$i]['total'] = $this->_get_count_from_autor($autores[$i]['id']);
        }

        return $autores;
    }

    public function getAllPaginated($first_record = 0, array $campos = []) {
//        debug_fn(__METHOD__);

        $autores = parent::getAllPaginated($this->_table, $campos, $first_record, REGISTROS_POR_PAGINA);
        for ($i = 0; $i < count($autores); $i++) {
            $autores[$i]['total'] = $this->_get_count_from_autor($autores[$i]['id']);
        }

        return $autores;
    }

    public function getById(int $id) {
        $autor = parent::getById($this->_table, $id)[0];
        $frases = $this->_get_frases_from_autor($autor['id']);
        $autor['total_frases'] = count($frases);
        $autor['frases'] = $frases;
        return $autor;
    }

    private function _get_frases_from_autor($autor_id) {
        $table = parent::getTableName('cita');
        $sql = "SELECT * FROM $table "
                . "WHERE id_autor = $autor_id";
        return parent::getSQL($sql);
    }

    private function _get_count_from_autor($autor_id) {
        $table = parent::getTableName('cita');
        $sql = "SELECT COUNT(*) AS total FROM $table "
                . "WHERE id_autor= $autor_id";
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
