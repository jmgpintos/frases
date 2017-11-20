<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos.css" rel="stylesheet" type="text/css" />
        <title><?php if (isset($this->titulo)) echo $this->titulo ?></title>
    </head>
    <body>
        <div id="main">
            <div id="header">
                <h1><?php echo APP_NAME; ?></h1>
            </div>

            <div id="menu_top">
                <ul>
                    <?php if (isset($_layoutParams['menu'])): ?>
                        <?php foreach ($_layoutParams['menu'] as $key => $value):
                            ?>
                            <li>
                                <a href="<?php echo $value['enlace'] ?>"><?php echo $value['titulo'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>


                </ul>
            </div>