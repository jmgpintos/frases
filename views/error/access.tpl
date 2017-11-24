<h2>{$mensaje}</h2>

<a href="{$_layoutParams.root}">Ir al inicio</a> | 
<a href="javascript:history.back(1)">Ir a la p&aacute;gina anterior</a>
@TODO convertir esto a smarty:
{php}
if(!Session::get('autenticado')){
    echo '<a href="{$_layoutParams.login}">Iniciar sesi&oacute;n</a>';
}
{/php}