
<h2>{$tituloHTML}</h2>


<hr>
<table>
{foreach item=it from=$usuarios}
    <tr>
        <td>{$it.usuario}</td>
        <td>{$it.email}</td>
        <td>{$it.telefono}</td>
        <td>{$it.apellidos}</td>
        <td>{$it.nombre}</td>
    </tr>
{/foreach}
</table>