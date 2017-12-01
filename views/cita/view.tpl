<div class='cita-bloque'>
    <div class='frase'>{$cita.frase}</div>
    <div class='autor'>
        <a href='{$_layoutParams.root}autor/index/{$cita.autor.id}'>    
            {$cita.autor.nombre}
        </a>
    </div>
    <div class='categoria'>
        <a href='{$_layoutParams.root}categoria/frases/{$cita.categoria.id}'>
            {$cita.categoria.nombre}
        </a>
    </div>
    <div class='etiquetas'>
        {foreach from=$cita.etiquetas key=myId item=it name=foo}            
            <a href='{$_layoutParams.root}etiquetas/frases/{$it.id}'>{$it.texto}</a>{if not $smarty.foreach.foo.last} - {/if}
        {/foreach}
    </div>
</div>