
<h2>Categor&iacute;as</h2>
    <ul>
        <div class="lista-categorias">
            {foreach from=$lista_categorias item=it}
                {counter assign='pos'}<br />
                <li  title="{$it.total} frases en '{$it.nombre|capitalize}'">
                    <a href='{$_layoutParams.root}categoria/ver/{$it.id}'>
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