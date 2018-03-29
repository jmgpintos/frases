
<!DOCTYPE html>
<html>
    <head>
        <title>{$titulo|default:"SIN TITULO"}</title>
        <meta charset="UTF-8" >
        <link href="{$_layoutParams.root}public/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{$_layoutParams.ruta_css}estilos.css" rel="stylesheet" type="text/css" />
        <link href="{$_layoutParams.ruta_css}responsive.css" rel="stylesheet" type="text/css" />
        <script src="{$_layoutParams.root}public/js/jquery.js" type="text/javascript"></script>
        <script src="{$_layoutParams.root}public/js/menu.js" type="text/javascript"></script>
        <link href="https://fonts.googleapis.com/css?family=Playball" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Arima+Madurai" rel="stylesheet"> 

        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}"type="text/javascript"></script>
            {/foreach}
        {/if}

    </head>
    <body>
        <div id="main">
            <div id="header">
                <h1><a href='{$_layoutParams.root}'>{$_layoutParams.configs.app_name}</a></h1>
            </div>

            <div id="myTopnav" class='topnav'>
                {if isset($_layoutParams.menu)}
                    {foreach item=it from=$_layoutParams.menu}
                        {if isset($_layoutParams.item) && $_layoutParams.item == $it.id}
                            {assign var ='_item_style' value= 'active'}
                        {else}
                            {assign var ='_item_style' value= ''}
                        {/if}
                        <a class='{$_item_style}' href="{$it.enlace}">{$it.titulo}</a>
                    {/foreach}
                {/if}
                <a class="buscador">
                    <form 
                        id="form-buscador" 
                        name="form-buscador" 
                        method="POST" 
                        action="{$_layoutParams.root}cita/buscar" >
                        <input 
                            class="hidden"
                            id="cadena-busqueda"
                            type="text" 
                            name="cadena-busqueda" 
                            />
                    </form>
                    <i class="fa fa-search" onclick="jQuery('#cadena-busqueda').toggleClass('hidden').focus()"></i>
                </a>
                <a href="javascript:void(0);" class="icon" onclick="menuHamburger();">
                    <i class='fa fa-navicon'></i>
                </a>
            </div>

            <div id='content'>
                <noscript>Para el correcto funcionamiento del sitio debe activar javascritp</noscript>
                {if isset($_error)}
                    <div id='error'>
                        <div class="titulo">
                            Error:
                        </div>
                        {$_error}
                    </div>
                {/if}
                {if isset($_mensaje)}
                    <div id='mensaje'>
                        <div class="titulo">
                            Mensaje:
                        </div>
                        {$_mensaje}
                    </div>
                {/if}

                {include file=$_contenido}


                <div class="back_link">
                    <a href="javascript:history.back(1)"><i class="fa fa-arrow-left"></i>Volver atr&aacute;s</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <div id="footer" style="text-align: center;">
                {$_layoutParams.configs.app_company}
                &mdash;
                {$_layoutParams.configs.app_slogan}
                &mdash;
                {$_layoutParams.configs.app_name}
            </div>
        </div>
    </body>
</html>