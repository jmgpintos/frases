

<h2>{$frase.frase}</h2>
Autor: {$frase.autor.nombre}<br/>
Categoria: {$frase.categoria.nombre}<br/>
Etiquetas: 
{foreach item=it from=$frase.etiquetas}
    {$it.texto}, 
{/foreach}