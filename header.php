<?php include_once("adm/src/Model/Database.php"); ?>
<?php include_once("adm/src/Model/Image.php"); ?>
<?php include_once("adm/src/Model/Model.php"); ?>
<?php include_once("adm/src/Model/Columnist.php"); ?>
<?php use Friweb\CMS\Model\Columnist; ?>

<?php

$columnist = new Columnist();
$columnists = $columnist->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);
$columnistsCategories = $columnist->getResultFromSelect(['ativo' => 1, 'publicar' => 1]);

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Êxito Rio - A Revista da Serra&Mar</title>
    <link href="./assets/css/normalize.css" rel="stylesheet">
    <link href="./assets/css/reset.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="img/favicon.ico" type="img/x-icon"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    
  </head>

  <body>
  <div class="loader-wrapper">
      <span class="loader"><span class="loader-inner"></span></span>
  </div>



  	<section id="menu-desktop-faixa" class="header-desktop">
	  	<div id="logo-faixa" class="company-logo">
	  		<a href="index.php"><img class="company-img-logo" src="img/logo.png" alt="Logotipo Êxito Rio"></a>
	  	</div>
	</section>
	
  	<!-- navbar desktop -->
  	<nav class="nav-desktop">
		<div class="dropdown">
			<a href="index.php" class="dropbtn">Home</a>	
				<div class="dropdown-content"> 			
		            <!-- <a href="#">Redes sociais</a> -->
		            <!--<a href="materias.php?page=1">Notícias</a>
		            <a href="especiais.php?page=1">Turismo Serra&Mar</a>-->
		            <a href="videos.php?page=1">Vídeos</a>
		          	<a href="index.php#sponsors-logos" id="sponsors-scroll">Empresas parceiras</a>
	          	</div>
        </div>

        <div class="dropdown">
			<div class="dropbtn drop-div-text">Serra & Mar</div>
				<div class="dropdown-content">
	            	<a href="onde_dormir.php?page=1">Onde Dormir</a>
	            	<a href="onde_comer.php?page=1">Onde Comer</a>
	            	<a href="onde_ir.php?page=1">Onde Ir</a>
	            	<a href="onde_comprar.php?page=1">Onde Comprar</a>
	            </div>
        </div>

		<a href="produtos_e_servicos.php">Guia Empresarial</a>

		<li><a href="materias.php?page=1">Notícias</a></li>

		<li><a href="imoveis.php?page=1">Imóveis</a></li>

		<a href="piadas.php?page=1">Diversão</a>

		<div class="dropdown">
			<div class="dropbtn drop-div-text">Colunas</div>
			<div class="dropdown-content">
                <?php while($colunista = $columnistsCategories->fetch_assoc()): ?>
                    <a href="colunista.php?id=<?=$colunista['chave_colunista']?>&page=1">
                        <?=$colunista['categoria_colunista']?>
                    </a>
                <?php endwhile ?>
	        </div>
        </div>

		<a href="about.php">Quem Somos</a>

		<a href="anuncie.php">Anuncie</a>
	</nav>

	

	<!-- navbar mobile -->
  	<header class="navbar">
  		<a href="index.php"><img class="company-img-logo" src="img/logo.png" alt="Logotipo Êxito Rio"></a>
  		<button class="menu-open"><i class="fa fa-bars"></i></button>

  		<nav class="barra-nav">
  			<button class="menu-close">x</button>
  			<ul class="main-menu">
  				<!-- <li><a href="index.php">Home</a></li> -->
				<li class="dropdown-mobile-container">
					<div class="dropdown-btn-mobile">Home <i class="bi bi-chevron-down"></i></div>
					<div class="dropdown-content-navbar">
						<!--<a href="index.php">Página inicial</a>
						<a href="materias.php?page=1">Notícias</a>-->
						<a href="videos.php?page=1">Vídeos</a>
						<a href="index.php#sponsors-logos" id="sponsors-scroll">Empresas parceiras</a> 
					</div>
				</li>

				<!--<li><a href="videos.php?page=1">Vídeos</a></li>
				<li><a href="index.php#sponsors-logos" id="sponsors-scroll">Empresas parceiras</a></li>-->


                <li class="dropdown-mobile-container">
                    <div class="dropdown-btn-mobile">Serra & Mar <i class="bi bi-chevron-down"></i></div>
                    <div class="dropdown-content-navbar">
                        <a href="onde_dormir.php?page=1">Onde Dormir</a>
                        <a href="onde_comer.php?page=1">Onde Comer</a>
                        <a href="onde_ir.php?page=1">Onde Ir</a>
                        <a href="onde_comprar.php?page=1">Onde Comprar</a>
                    </div>
                </li>

  				<li><a href="produtos_e_servicos.php">Guia Empresarial</a></li>
				<li><a href="materias.php?page=1">Notícias</a></li>
				<li><a href="imoveis.php?page=1">Imóveis</a></li>
  				<li><a href="piadas.php?page=1">Diversão</a></li>

                <li class="dropdown-mobile-container">
                    <div class="dropdown-btn-mobile">Colunas <i class="bi bi-chevron-down"></i></div>
                    <div class="dropdown-content-navbar">
                        <?php while($colunista = $columnists->fetch_assoc()): ?>
                            <a href="colunista.php?id=<?=$colunista['chave_colunista']?>&page=1">
                                <?=$colunista['categoria_colunista']?>
                            </a>
                        <?php endwhile ?>
                    </div>
                </li>

  				<li><a href="about.php">Quem Somos</a></li>
  				<li style="margin-bottom: 2em;"><a href="anuncie.php">Anuncie</a></li>
  			</ul>
  		</nav>
  	</header>



