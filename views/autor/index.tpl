
<h2>{$tituloHTML}</h2>


<table >
    {foreach item=item from=$autores}
        <tr>
            <td>{$item.nombre}</td>
            <td>{$item.total}</td>
        </tr>
    {/foreach}
</table>