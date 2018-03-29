

<div class="back_link">
    <a href="{$_layoutParams.root}/categoria/lista"><i class="fa fa-arrow-left"></i>Volver a la lista de Categor&iacute;as</a>
</div>
<div class='clearfix'></div>
<h2>Frases de la categoria <span class='nombre'>{$nombre_categoria}</span></h2>

<table >
    <thead>
        <tr>
            <th>Cita</th>
            <th>Autor</th>
        </tr>
    </thead>
    <tbody>
        </tr>
        {foreach item=it from=$frases}
            <tr>
                <td>
                    <a href='{$_layoutParams.root}cita/view/{$it.id}'>
                        {$it.frase}
                    </a>
                </td>

                <td style="width: 20%;">
                    <a href='{$_layoutParams.root}autor/view/{$it.autor.id}'>
                        {$it.autor.nombre}
                    </a>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
{$paginacion}
