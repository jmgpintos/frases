
<h2>{$tituloHTML}</h2>


<table >
    <thead>
        <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Total</th>
                <th>wiki</th>
                <th>google</th>
        </tr>
    </thead>
    {foreach item=item from=$autores}
        <tr>
            <td>{$item.id}</td>
            <td>{$item.nombre}</td>
            <td>{$item.total}</td>
            <td>{$item.l_wiki}</td>
            <td>{$item.l_google}</td>
        </tr>
    {/foreach}
</table>
{$paginacion}