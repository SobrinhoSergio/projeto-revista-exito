<?
  include("../include/sistema_conexao.php");
  include("../include/sistema_zeros.php");
  include("../include/sistema_data.php");
  include("../include/sistema_link.php");
  include("../include/funcao_tirar_acentos.php");

  include("include/sistema_tags.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

    <meta http-equiv="Content-Language" content="pt-br">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">

    <meta name="description" content="<? echo $descricao; ?>">

    <meta name="rating" content="general">
    <meta name="robots" content="index,follow">
    <meta name="Googlebot" content="all">
    <meta name="revisit-after" content="15 days">

    <meta name="keywords" content="<? echo $palavras_chave; ?>">




    <title><? echo $titulo; ?></title>


    <link rel="stylesheet" type="text/css" href="css/formulario.css" />
    <link rel="stylesheet" type="text/css" href="css/estilos.css" />
    <link rel="stylesheet" type="text/css" href="css/barra_servicos.css" />


    <script type="text/javascript" src="js/geral.js" ></script>
    <script type="text/javascript" src="js/jquery.js" ></script>
    <script type="text/javascript" src="js/cycle.js"></script>

  <link rel="stylesheet" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/slider-pro.min.css">
  <link rel="stylesheet" href="../css/examples.css">
  <link rel="stylesheet" type="text/css" href="../carrossel/tango/skin.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.fancybox.css">

    <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen, projection"/>
  <script type="text/javascript" language="javascript" src="../js/jquery.dropdownPlain.js"></script>



<script type="text/javascript"> 
$(document).ready(function() {
    $('.slideshow').cycle({
		fx: 'scrollDown',
            timeout: 0, 
            next:   '#next2', 
            prev:   '#prev2' 
	});
});
</script>





  </head>







  <body>

    <? include ("../include/topo_revista.php"); ?>
    <div id="sombra-barra-servicos">
    </div>
    <div id="conteudo">
     
      <div id="miolo"><? include("include/conteudo_" . $_REQUEST['conteudo'] . ".php"); ?></div>
    
    </div>
      <div id="rodape"><? include("../include/footer_revista.php") ?></div>
    <? include("../include/stats_all_inv.php"); ?>

  </body>
</html>

<?
  mysql_close($conexao);
?>