<?php

title('PRUEBA debug_msg.php');
$db = new Database();

$b = TRUE;
debug($b, 'Prueba booleano TRUE');

$b = FALSE;
debug($b, 'Prueba booleano FALSE');

$b = NULL;
debug($b, 'Prueba NULO');



$p = new Request();
debug($p, 'p');

title('FIN PRUEBA debug_msg.php');
