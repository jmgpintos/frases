
<h2>{$titulo}</h2>
Hola desde vista smarty
<pre>
    {php}debug($usuarios);{/php}
</pre>
{$usuarios}
{foreach item=it from=usuarios}
    {$it}
{/foreach}