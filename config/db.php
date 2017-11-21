<?php

if (ENV == 'local') {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'kodak80');
    define('DB_NAME', 'citas');
    define('DB_CHAR', 'utf8');
    define('TABLES_PREFIX','');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'kodak80');
    define('DB_NAME', 'citas');
    define('DB_CHAR', 'utf8');
    define('TABLES_PREFIX','');
}


define('REGISTROS_POR_PAGINA', 10);

define('REGISTROS_POR_PAGINA_LIST', REGISTROS_POR_PAGINA);
define('REGISTROS_POR_PAGINA_CARD', 10);
define('REGISTROS_POR_PAGINA_TABLE', 7);