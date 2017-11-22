<?php

class EtiquetaModel extends Model {

    private $_table = 'etiqueta';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {
        $etiquetas = parent::getAll($this->_table, $campos);

        for ($i = 0; $i < count($etiquetas); $i++) {
            $etiquetas[$i]['total'] = $this->_get_count_from_etiqueta($etiquetas[$i]['id']);
        }

        return $etiquetas;
    }

    public function getAllPaginated($first_record = 0, array $campos = []) {
        $etiquetas = parent::getAllPaginated($this->_table, $campos, $first_record, REGISTROS_POR_PAGINA);

        for ($i = 0; $i < count($etiquetas); $i++) {
            $etiquetas[$i]['total'] = $this->_get_count_from_etiqueta($etiquetas[$i]['id']);
        }

        return $etiquetas;
    }

    public function getById(int $id) {
        $etiqueta = parent::getById($this->_table, $id)[0];

        $frases = $this->_get_frases_from_etiqueta($etiqueta['id']);
        $etiqueta['total'] = count($frases);
        $etiqueta['frases'] = $frases;

        return $etiqueta;
    }

    private function _get_frases_from_etiqueta($etiqueta_id) {
        $tbl_cita = parent::getTableName('cita');
        $tbl_cita_etiqueta = parent::getTableName('cita_etiqueta');

        $sql = "SELECT c.* "
                . "FROM $tbl_cita c , $tbl_cita_etiqueta ce "
                . "WHERE c.id=ce.id_cita AND ce.id_etiqueta = $etiqueta_id";

        return parent::getSQL($sql);
    }

    private function _get_count_from_etiqueta($etiqueta_id) {
        $tbl_cita = parent::getTableName('cita');
        $tbl_cita_etiqueta = parent::getTableName('cita_etiqueta');

        $sql = "SELECT COUNT(*) AS cuenta "
                . "FROM $tbl_cita c , $tbl_cita_etiqueta ce "
                . "WHERE c.id=ce.id_cita AND ce.id_etiqueta = $etiqueta_id";

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
