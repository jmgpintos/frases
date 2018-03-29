<?php

class CitaModel extends Model {

    private $_table = 'cita';

    public function __construct() {
        parent::__construct();
    }

    public function getAll(array $campos = array()) {
        $frases = parent::getAll($this->_table, $campos);

        for ($index = 0; $index < count($frases); $index++) {
            $frases[$index] = $this->_extend($frases[$index]);
        }

        return $frases;
    }

    public function getAllPaginated($first_record = 1, array $campos = [], $total_por_pagina = null) {
        if (!$total_por_pagina) {
            $total_por_pagina = REGISTROS_POR_PAGINA;
        }
        $frases = parent::getAllPaginated($this->_table, $campos, $first_record, $total_por_pagina, 'frase');

        for ($index = 0; $index < count($frases); $index++) {
            $frases[$index] = $this->_extend($frases[$index]);
        }

        return $frases;
    }

    public function getById(int $id) {
        return $this->_extend(parent::getById($this->_table, $id)[0]);
    }

    public function getBusqueda($etiquetas, $pagina, $total_por_pagina) {
        $tbl_etiqueta = parent::getTableName('etiqueta');
        $tbl_cita_etiqueta = parent::getTableName('cita_etiqueta');
        $implode = implode("|", $etiquetas);

        $sql = "SELECT * FROM $this->_table WHERE id IN ("
                . "SELECT id_cita FROM $tbl_cita_etiqueta WHERE id_etiqueta IN ("
                . "SELECT id FROM $tbl_etiqueta WHERE texto REGEXP ('$implode')"
                . "))";
        debug($sql);
        $resultado = parent::getSQL($sql);
        $cuenta = count($resultado);
        $rs = array_slice($resultado, ($pagina - 1) * $total_por_pagina, $total_por_pagina);
        return ['cuenta' => $cuenta, 'rs' => $rs];
    }

    public function getRandom() {
        $total_records = parent::getCount($this->_table);
        $id = rand(1, $total_records);

        return $this->getById($id);
    }

    private function _extend($frase) {
        if (isset($frase['id_autor'])) {
            $frase['autor'] = $this->_getAutor($frase['id_autor']);
        }

        if (isset($frase['id_categoria'])) {
            $frase['categoria'] = $this->_getCategoria($frase['id_categoria']);
        }

        if (isset($frase['id'])) {
            $frase['etiquetas'] = $this->_getEtiquetas($frase['id']);
        }

        return $frase;
    }

    private function _getAutor($id_autor) {
        return parent::getById('autor', $id_autor)[0];
    }

    private function _getCategoria($id_categoria) {
        return parent::getById('categoria', $id_categoria)[0];
    }

    private function _getEtiquetas($id_frase) {
        $tbl_etiqueta = parent::getTableName('etiqueta');
        $tbl_cita_etiqueta = parent::getTableName('cita_etiqueta');

        $sql = "SELECT e.* "
                . "FROM $tbl_etiqueta e , $tbl_cita_etiqueta ce "
                . "WHERE e.id=ce.id_etiqueta AND ce.id_cita = $id_frase";

        return parent::getSQL($sql);
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
