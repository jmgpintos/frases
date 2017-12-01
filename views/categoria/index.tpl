
<h2>{$tituloHTML}</h2>


<table>
    <thead>
        <tr>
            {foreach item=item from=$columnas}
                <th>{$item}</th>
                {/foreach}
        </tr>
    </thead>
    {foreach item=item from=$categorias}
        <tr>
            <td>{$item.nombre}</td>
            <td>{$item.descripcion}</td>
            <td>{$item.total}</td>
        </tr>
    {/foreach}
</table>
{$paginacion}