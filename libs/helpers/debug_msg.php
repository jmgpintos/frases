<?php

/**
 * Funciones para la salida de datos por pantalla en la etapa de desarrollo
 */
if (!function_exists("debug_fn")) {

    /**
     * 
     * @param String $fn_name
     * @param array $args
     * @param bool $always_show
     */
    function debug_fn(String $fn_name, array $args = [], bool $always_show = FALSE) {
        if (DEBUG || $always_show) {
            print CR . "<pre>";
            print "<strong>FUNCTION $fn_name</strong>";
            debug_arr($args, 'args');
            print "</pre>";
        }
    }

}

if (!function_exists("debug_method")) {

    /**
     * 
     * @param String $method_name
     * @param array $args
     * @param bool $always_show
     */
    function debug_method(String $method_name, array $args, bool $always_show = FALSE) {
        if (DEBUG || $always_show) {
            print CR . "<pre>";
            print "<strong>METHOD $method_name</strong>";
            debug_arr($args, 'args');
            print "</pre>";
        }
    }

}

if (!function_exists("debug_msg")) {

    /**
     * 
     * @param String $str
     * @param bool $always_show
     */
    function debug_msg(String $str, bool $always_show = FALSE) {
        if (DEBUG || $always_show) {
            print CR . "<pre>";
            if ($str != null) {
                print $str;
            }
            print "</pre>";
        }
    }

}

if (!function_exists('debug')) {

    /**
     * 
     * @param type $obj
     * @param String $title
     * @param bool $always_show
     */
    function debug($obj, String $title = NULL, bool $always_show = false) {
        $title_and_type = add_type_to_title($obj, $title);
        $tipo = gettype($obj);
        if (DEBUG || $always_show) {
            switch ($tipo) {
                case 'boolean':
                    debug_bool($obj, $title_and_type);
                    break;
                case 'integer':
                case 'double':
                case 'string':
                    debug_str($obj, $title_and_type);
                    break;
                case 'array':
                    debug_arr($obj, $title_and_type);
                    break;
                case 'object':
                    debug_obj($obj, $title_and_type);
                    break;
                case 'resource':
                    break;
                case 'NULL':
                    debug_null($title_and_type);
                    break;
                case 'unknow type':
                    break;
                default:
                    break;
            }
        }
    }

}

if (!function_exists("add_type_to_title")) {

    /**
     * 
     * @param type $obj
     * @param String $title
     * @return type
     */
    function add_type_to_title($obj, String $title = NULL) {
        $type = gettype($obj);
        return " <small>[$type]</small> $title";
    }

}

if (!function_exists('debug_str')) {

    /**
     * 
     * @param String $str
     * @param String $title
     */
    function debug_str(String $str, String $title = NULL) {
        print CR . "<pre>";
        if ($title) {
            print "<strong>" . $title . "</strong>: ";
        }
        if ($str != null) {
            print $str;
        } else {
            print 'NULL';
        }
        print "</pre>";
    }

}

if (!function_exists('debug_simple')) {

    /**
     * 
     * @param String $str
     * @param String $title
     */
    function debug_simple(String $str, bool $always_show = false) {
        if (DEBUG || $always_show) {
            print PHP_EOL . "<pre>";
            if ($str != null) {
                print $str;
            } else {
                print 'NULL';
            }
            print "</pre>";
        }
    }

}

if (!function_exists('debug_arr')) {

    /**
     * 
     * @param array $arr
     * @param String $title
     */
    function debug_arr(array $arr, String $title = NULL) {
        print CR . "<pre>";
        if ($title) {
            print "<strong>" . $title . "</strong>: ";
        }
        if (count($arr) > 0) {
            print "<ul>";
            foreach ($arr as $k => $v) {
                if (gettype($v) == 'array' || gettype($v) == 'object') {
                    debug($v, $k);
                } else {
                    print "<li>$k => $v</li>";
                }
            }
            print "</ul>";
        }
        print "</pre>";
    }

}

if (!function_exists('debug_obj')) {

    /**
     * 
     * @param object $obj
     * @param String $title
     */
    function debug_obj($obj, String $title = NULL) {
        print CR . "<pre>";
        if ($title) {
            print "<strong>" . $title . "</strong>: ";
        }
        print SEPARATOR;

        debug(get_class($obj), 'CLASS');
        debug(get_object_vars($obj), 'VARS');
        debug(get_class_methods(get_class($obj)), 'METHODS');

        print SEPARATOR;
        print "</pre>";
    }

}

if (!function_exists("debug_bool")) {

    /**
     * 
     * @param bool $bool
     * @param String $title
     */
    function debug_bool(bool $bool, String $title = NULL) {
        print CR . "<pre>";
        if ($title) {
            print "<strong>" . $title . "</strong>: ";
        }
        if ($bool) {
            print "TRUE";
        } else {
            print "FALSE";
        }
        print "</pre>";
    }

}

if (!function_exists("debug_null")) {

    /**
     * 
     * @param type $null
     * @param String $title
     */
    function debug_null(String $title = NULL) {
        print CR . "<pre>";
        if ($title) {
            print "<strong>" . $title . "</strong>: ";
        }
        print "NULL";
        print "</pre>";
    }

}

if (!function_exists("title")) {

    function title($string, $always_show = FALSE) {

        if (DEBUG || $always_show) {
            print CR . "<pre>";
            print "<h2>---- $string ----</h2>";
            print "</pre>";
        }
    }

}
