
<h2>FRASES</h2>


<table >
    {foreach item=it from=$frases}
    <tr>
        <td>{$it.frase}</td>
        <td>{$it.autor.nombre}</td>
        <td>{$it.categoria.nombre}</td>
    </tr>
    {/foreach}
</table>