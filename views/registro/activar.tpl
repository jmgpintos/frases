<h2>Activaci&oacute;n de cuenta</h2>

<a href="{$_layoutParams.root}">Ir al inicio</a> 

{php}
if(!Session::get('autenticado')){
    echo '<a href="{$_layoutParams.login}">Iniciar sesi&oacute;n</a>';
}
{/php}