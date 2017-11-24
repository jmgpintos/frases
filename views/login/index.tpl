<h2>Iniciar sesi&oacute;n</h2>

<form name='form1' method='post' action=''>
    <input type='hidden' value='1' name='enviar'>
    <p>
        <label>Usuario: </label>
        <input type='text' name='usuario' value='{$datos.usuario}'/>
    </p>
    <p>
        <label>Password: </label>
        <input type='password' name='password' />
    </p>
    <p>
        <input type='submit' value='Enviar' />
    </p>
</form>
{$usuario}