<h2>Cita del d&iacute;a</h2>
<div class='cita-bloque'>
    <div class='frase'>{$frase.frase}</div>
    <div class='autor'>
        <a href='{$_layoutParams.root}autor/ver/{$frase.autor.id}'>    
            {$frase.autor.nombre}
        </a>
    </div>
    <div class='categoria'>
        <a href='{$_layoutParams.root}categoria/ver/{$frase.categoria.id}'>
            {$frase.categoria.nombre}
        </a>
    </div>
    <div class='etiquetas'>
        {foreach from=$frase.etiquetas key=myId item=it name=foo}            
            <a href='{$_layoutParams.root}etiquetas/frases/{$it.id}'>{$it.texto}</a>{if not $smarty.foreach.foo.last} - {/if}
        {/foreach}
    </div>
</div>
<h2>Categor&iacute;as</h2>
    <ul>
        <div class="lista-categorias">
            {foreach from=$lista_categorias item=it}
                {counter assign='pos'}<br />
                <li  title="{$it.total} frases en '{$it.nombre|capitalize}'">
                    <a href='{$_layoutParams.root}categoria/frases/{$it.id}'>
                        {$it.nombre}
                    </a>
{*                    <div class="cuenta">*}
                        <span class="total">({$it.total})</span>
{*                    </div>*}
                </li>
                {if $pos%$break eq 0}</div><div class="lista-categorias">{/if }
            {/foreach}
    </ul>
    <div class="clearfix"></div>