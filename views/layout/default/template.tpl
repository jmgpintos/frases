
<!DOCTYPE html>
<html>
    <head>
        <title>{$titulo|default:"SIN TITULO"}</title>
        <meta charset="UTF-8" >
        <link href="{$_layoutParams.ruta_css}estilos.css" rel="stylesheet" type="text/css" />
        <script src="{$_layoutParams.root}public/js/jquery.js" type="text/javascript"></script>

        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}"type="text/javascript"></script>
            {/foreach}
        {/if}

    </head>
    <body>
        <div id="main">
            <div id="header">
                <h1>{$_layoutParams.configs.app_name}</h1>
            </div>

            <div id="menu_top">
                <ul>
                    {if isset($_layoutParams.menu)}
                        {foreach item=it from=$_layoutParams.menu}

                            {if isset($_layoutParams.item) && $_layoutParams.item == $it.id}
                                {assign var ='_item_style' value= 'current'}
                            {else}
                                {assign var ='_item_style' value= ''}
                            {/if}

                            <li>
                                <a class='{$_item_style}}' href="{$it.enlace}">{$it.titulo}</a>
                            </li>
                        {/foreach}
                    {/if}
                </ul>
            </div>
                
            <div id='content'>
                <noscript>Para el correcto funcionamiento del sitio debe activar javascritp</noscript>
                {if isset($_error)}
                    <div id='error'>{$_error}</div>
                {/if}
                {if isset($_mensaje)}
                    <div id='mensaje'>{$_mensaje}</div>
                {/if}

                {include file=$_contenido}


            </div>

            <div id="footer" style="text-align: center;">
                <hr>
                {$_layoutParams.configs.app_company}
                &mdash;
                {$_layoutParams.configs.app_slogan}
                &mdash;
                {$_layoutParams.configs.app_name}
            </div>
        </div>
    </body>
</html>