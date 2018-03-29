{if isset($autor)}
    <h2>Frases de {$autor.nombre}</h2>
    {$autor.total_frases} frases
    <ul>
        {foreach item=it from=$autor.frases}
            <li>{$it.frase}</li>
            {/foreach}
    </ul>
{/if}