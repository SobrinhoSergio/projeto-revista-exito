<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--    <link rel="stylesheet" href="--><?//= dirname($_SERVER['PHP_SELF'],3)?><!--/assets/css/normalize.css">-->
    <link rel="stylesheet" href="<?= dirname("../materia.php") ?>/assets/css/normalize.css">
<!--    <link rel="stylesheet" href="--><?//= dirname($_SERVER['PHP_SELF'],3)?><!--/assets/css/reset.css">-->
    <link rel="stylesheet" href="<?= dirname("../materia.php") ?>/assets/css/reset.css">
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="icon" href="<?=dirname("../materia.php")?>/img/favicon.ico" type="img/x-icon"/>
    <title>Administração - Êxito Rio</title>
</head>

<body>
    <?php //session_start(); ?>
    <!-- só mostra a navbar para usuários logados -->
    <?php if(isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['password']) && isset($_SESSION['type_user'])): ?>
        <header class="navbar">
            <a href="<?= dirname("../materia.php") ?>">
                <img class="company-img-logo" src="<?= dirname("../materia.php") ?>/img/logo.png" alt="Logotipo Êxito Rio">
            </a>

            <button class="menu-open"><i class="fa fa-bars"></i></button>

            <nav class="barra-nav">
                <button class="menu-close">x</button>
                <ul class="main-menu">
                    <li><a href="<?= dirname("../materia.php") ?>/adm">Home</a></li>
                    <li class="help"><a class="help" target="_blank" href="https://www.friweb.com.br/">Suporte</a></li>
                </ul>
            </nav>
        </header>


        <section id="menu-desktop-faixa" class="header-desktop">
            <div id="logo-faixa" class="company-logo">
                <a href="<?=dirname("../materia.php")?>"><img class="company-img-logo" src="<?= dirname("../materia.php") ?>/img/logo.png" alt="Logotipo Êxito Rio"></a>
            </div>
        </section>
        
        <!-- navbar desktop -->
        <nav class="nav-desktop">
            <a href="<?= dirname("../materia.php") ?>/adm">Home</a>

            <a href="https://www.friweb.com.br/" target="_blank">Suporte</a>
        </nav>



    <?php endif ?>