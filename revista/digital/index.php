<?php

  include("../../include/sistema_zeros.php");

  $edicao = zerosaesquerda($_REQUEST['edicao'],6);

?>



<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Revista Êxito Rio - Versão Impressa</title>

    <meta name="description" content="A Revista Êxito Friweb publica matérias sobre festas, eventos, saúde, meio-ambiente, lazer, entretenimento e muito mais. Aqui você encontra fotos e vídeos de festas. Esta página trata do seguinte assunto: <? echo $titulo; ?>">
    <meta name="keywords" content="Revista, Noite, Festas, Eventos, Night, Nova Friburgo, Região Serrana, Fotos, Balada, Gastronomia, Restaurante, Bares, Bar, Casas Noturnas">
    <meta name="robots" content="index,follow">

<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="js/PopUpWin.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #ffffff;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0','width','100%','height','100%','src','swf/magazine','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','bgcolor','#ffffff','allowFullScreen','true','allowScriptAccess','sameDomain','movie','swf/<?php echo $edicao; ?>' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%">
  <param name="movie" value="swf/<?php echo $edicao; ?>.swf" />
  <param name="quality" value="high" />
  <param name="bgcolor" value="#ffffff" />
  <param name="allowFullScreen" value="true" />
  <param name="allowScriptAccess" value="sameDomain" />
  <embed src="swf/magazine.swf" width="100%" height="100%" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowFullScreen="true" allowScriptAccess="sameDomain"></embed>
</object></noscript></body></html>