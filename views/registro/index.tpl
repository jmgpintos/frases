<h2>Registro</h2>

<form name='form1' method='post' action=''>
    <input type='hidden' value='1' name='enviar'>
    <p>
        <label>Apellidos: </label>
        <input type='text' name='apellidos' value='{$datos.apellidos}'/>
    </p>
    <p>
        <label>Nombre: </label>
        <input type='text' name='nombre' value='{$datos.nombre}'/>
    </p>
    <p>
        <label>Usuario: </label>
        <input type='text' name='usuario' value='{$datos.usuario}'/>
    </p>
    <p>
        <label>Email: </label>
        <input type='text' name='email' value='{$datos.email}'/>
    </p>
    <p>
        <label>Password: </label>
        <input type='password' name='password' />
    </p>
    <p>
        <label>Confirmar: </label>
        <input type='password' name='confirmar' />
    </p>
    <p>
        <input type='submit' value='Enviar' />
    </p>
</form>
{$usuario}