
<h2>FRASES</h2>

<table >
    {foreach item=it from=$frases}
        <tr>
{*            <td>{$it.id}</td>*}
            <td>{$it.frase}</td>
            <td>{$it.autor.nombre}</td>
            <td>
                <a href="{$_layoutParams.root}categoria/frases/{$it.categoria.id}">
                    {$it.categoria.nombre}
                </a>
            </td>
        </tr>
    {/foreach}
</table>
{$paginacion}