<?php

//estados usuario
define('USUARIO_ESTADO_ACTIVADO', 1);
define('USUARIO_ESTADO_NO_ACTIVADO', 0);

//roles usuario. Ojo, no es lo mismo que la tabla usuarios.
define('USUARIO_ROL_ADMIN', 3);
define('USUARIO_ROL_EDITOR', 2);
define('USUARIO_ROL_USUARIO', 1);
define('DEFAULT_ROLE', 3); //Ojo el 3 significa usuario en la tabla rol