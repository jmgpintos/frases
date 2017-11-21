<?php

    debug_simple(ENV);
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

