<?php

/**
 * Description of paginador
 *
 * @author Jose Manuel Garcia Pintos <jmgpintos@gmail.com>
 */
class Paginador {

    private $_datos;
    private $_paginacion;

    public function __construct() {
        $this->_datos = [];
        $this->_paginacion = [];
    }

    public function paginar($query, $total_registros,$pagina = false, $limite = false, $paginas = false) {
        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = REGISTROS_POR_PAGINA;
        }

        if ($pagina && is_numeric($pagina)) {
            $pagina = $pagina;
            $inicio = ($pagina - 1) * $limite;
        } else {
            $pagina = 1;
            $inicio = 0;
        }
        $total = ceil($total_registros / $limite);
//        $this->_datos = array_slice($query, $inicio, $limite);
        $this->_datos = $query;

//        $this->_datos = $query;

        $paginacion = [];
        $paginacion['actual'] = $pagina;
        $paginacion['total'] = $total;

        if ($pagina > 1) {
            $paginacion['primero'] = 1;
            $paginacion['anterior'] = $pagina - 1;
        } else {
            $paginacion['primero'] = '';
            $paginacion['anterior'] = '';
        }

        if ($pagina < $total) {
            $paginacion['ultimo'] = $total;
            $paginacion['siguiente'] = $pagina + 1;
        } else {
            $paginacion['ultimo'] = '';
            $paginacion['siguiente'] = '';
        }

        $this->_paginacion = $paginacion;
        $this->_rangoPaginacion($paginas);
//        debug($paginacion, '$paginacion');
//        debug($this->_paginacion, '$this->_paginacion');
//        debug($this->_datos, '$this->_datos');
//        debug($query, 'query');
//        exit;
        return $this->_datos;
    }

    private function _rangoPaginacion($num_pags = false) {
        if ($num_pags && is_numeric($num_pags)) {
            $num_pags = $num_pags;
        } else {
            $num_pags = REGISTROS_POR_PAGINA;
        }

        $total_paginas = $this->_paginacion['total'];
        $pagina_seleccionada = $this->_paginacion['actual'];
        $rango = ceil($num_pags / 2);
        $paginas = [];

        $rango_derecho = $total_paginas - $pagina_seleccionada;


        if ($rango_derecho < $rango) {
            $resto = $rango - $rango_derecho;
        } else {
            $resto = 0;
        }

        $rango_izquierdo = $pagina_seleccionada - ($rango + $resto);

        for ($i = $pagina_seleccionada; $i > $rango_izquierdo; $i--) {
            if ($i == 0) {
                break;
            }
            $paginas[] = $i;
        }
        sort($paginas);

        if ($pagina_seleccionada < $rango) {
            $rango_derecho = $num_pags;
        } else {
            $rango_derecho = $pagina_seleccionada + $rango;
        }

        for ($i = $pagina_seleccionada + 1; $i <= $rango_derecho; $i++) {
            if ($i > $total_paginas) {
                break;
            }
            $paginas[] = $i;
        }
//        debug($paginas, '$paginas');
//
//        debug($num_pags, '$num_pags');
//        debug($total_paginas, '$total_paginas');
//        debug($pagina_seleccionada, '$pagina_seleccionada');
//        debug($rango, '$rango');
//        debug($resto, '$resto');
//        debug($rango_derecho, '$rango_derecho');
//        debug($rango_izquierdo, '$rango_izquierdo');
//        debug($paginas, '$paginas');
//        exit;
        $this->_paginacion['rango'] = $paginas;

        return $this->_paginacion;
    }

    public function getView($vista, $link = false) {
        $rutaView = ROOT . 'views' . DS . '_paginador' . DS . $vista . '.php';

        if ($link) {
            $link = BASE_URL . $link . '/';
        }

        if (is_readable($rutaView)) {
            //metemos el contenido de la vista en la variable $contenido
            ob_start();
            include $rutaView;
            $contenido = ob_get_contents();
            ob_end_clean();
            return $contenido;
        }

        throw new Exception('Error de paginacion');
    }

}
