<script type="text/javascript">



Cufon.replace('.cufon', { fontFamily: 'Terminal Dosis', hover: true});



</script>

<?php



	date_default_timezone_set('America/Sao_Paulo');

	

	  function zerosaesquerda2($string, $tam)

	  {

		$zerosacolocar = $tam - strlen($string);

	

		$zeros="";

		for ($i=1;$i<=$zerosacolocar;$i++)

		{

		  $zeros = "0$zeros";

		}

		$string = "$zeros$string";



		return $string;

	  }

	  

  function RetornaData($data)

  {

    $year = substr ( $data, 0, 4 );

    $month = substr ( $data, 4, 2 );

    $day = substr ( $data, 6, 2 );

	

	return 	$day."/".$month."/".$year;

  }

	  





  if(file_exists("include/sistema_conexao.php"))

  {

    include("include/sistema_conexao.php");

  }

  else

  {

    if(file_exists("../include/sistema_conexao.php"))

    {

      include("../include/sistema_conexao.php");

    }

  }

	  

	  

?>







<script defer="defer" language="javascript" type="text/javascript" charset="utf-8" >

	function Ajax(mes, ano){

	

		$.ajax(

		{

			  type: "GET",

			 

			  url: "calendario/calendario.php",

			 

			  data: "mes=" + mes + "&ano=" + ano,

			 

			  beforeSend: function() {

				$('#div_calendario').html('<p class="sub_titulo_evento" style="margin-top:25px;margin-left:10px;">Processando...</p>');

			  },

			  

			  success: function(txt) {

				$('#div_calendario').html(txt);

			  },

			  

			  error: function(txt) {

				alert('Houve um problema interno. tente novamente mais tarde.');

			  }

			

	   }	

	   );

	}

</script>



<?php



if(isset($_REQUEST['mes']) && isset($_REQUEST['ano'])){

	$mes = $_REQUEST['mes'];

	$ano = $_REQUEST['ano'];

}

else{

	$mes = date("n");

	$ano = date("Y");

}



$primeiro_dia_do_mes = date("w", mktime(0, 0, 0, $mes , 1, $ano));

$dias_no_mes = date("t", mktime(0, 0, 0, $mes , 1, $ano));





$proximo_mes =  $mes + 1;

$anterior_mes = $mes -1;

 

function NumeroLinhas($pdm, $dnm){

	if( ($pdm >= 5) && ($dnm == 31) ){

		return 6; 

	}

	else{

		return 5;

	}

}

function Menu(){



switch($GLOBALS['mes']+1){



	case 1 :{

		$m = "Janeiro";

		break;		

	}

	case 2 :{

		$m = "Fevereiro";

		break;		

	}

	case 3 :{

		$m = "Mar&ccedil;o";

		break;		

	}

	case 4 :{

		$m = "Abril";

		break;		

	}

	case 5 :{

		$m = "Maio";

		break;		

	}

	case 6 :{

		$m = "Junho";

		break;		

	}

	case 7 :{

		$m = "Julho";

		break;		

	}

	case 8 :{

		$m = "Agosto";

		break;		

	}

	case 9 :{

		$m= "Setembro";

		break;		

	}

	case 10 :{

		$m = "Outubro";

		break;		

	}

	case 11 :{

		$m = "Novembro";

		break;		

	}

	case 12 :{

		$m = "Dezembro";

		break;		

	}

	default :{

		$m = "Janeiro";

		break;		

	}



}



	$data = $m." / ".$GLOBALS['ano'];



	return $data;

}



function DataPhp($day){

	return zerosaesquerda2($day,2)."/".zerosaesquerda2($GLOBALS['mes'],2)."/".date("Y") ;

}



function RetornaMes($data){

	list($dia, $mes, $ano) = explode("/", $data);

	return $mes;

}



function VerificaEvento($day){


		

	$sql_eventos = " SELECT * FROM tabela_eventos WHERE SUBSTR(data_evento, 7 ) = '". zerosaesquerda2($day, 2)."' AND publicar = 1 AND SUBSTR(data_evento, 1 ,4) = '".date("Y")."' ";



	//echo $sql_eventos;
	


	$rs_eventos = mysqli_query($GLOBALS['conexao'], $sql_eventos);

	


	$fetch_eventos = mysqli_fetch_array($rs_eventos);


		
	$cod = $fetch_eventos['codigo_evento'];

	

	$data1 = $fetch_eventos['data_evento'];



	//echo $fetch_eventos['data_evento'];



	$data2 = RetornaData($fetch_eventos['data_evento']);







	if($data2 == DataPhp($day)){

		//echo "<a href='conteudo.php?conteudo=eventos&data_evento=".$data1."' class='marcado' title='".$data2."' >".$day."</a>";



        //$link_ht = linkht('data,',$data1,'Eventos do Site Pontinha de Sol.');



        echo '<a href="data,'.$data1.',Eventos do Site Pontinha de Sol.html" class="marcado" title="'.$data2.'">'.$day.'</a>';

	}

	else{

		if($day == date("j")){

				echo "<div class='hoje' >".$day."</div>";

		}

		else{

			echo "<div class='desmarcado' >".$day."</div>";

		}

	}



}

?>

<div id="div_calendario">



<table class="calendario" >

	<tr>

    	<td colspan="7" class="titulo cufon"><a href="calendario.html" style="text-decoration:none;">CALEND&Aacute;RIO DE EVENTOS</a></td>

    </tr>



    <tr>



	<?php for($i = 1; $i <= 7; $i++){?>

    	

        <td class="dia-semana">

        	<?php

				switch($i){

					case 1 :{

						echo "DOM";

						break;		

					}

					case 2 :{

						echo "SEG";

						break;		

					}

					case 3 :{

						echo "TER";

						break;

					}

					case 4 :{

						echo "QUA";

						break;		

					}

					case 5 :{

						echo "QUI";

						break;		

					}

					case 6 :{

						echo "SEX";

						break;		

					}

					case 7 :{

						echo "S&Aacute;B";

						break;		

					}

				}	

			?>

        </td>

        

	<?php } ?>

    

    </tr>

	

    <!-- COLUNAS DIAS -->

	<?php

	$day = 1;

	$flag = $primeiro_dia_do_mes;

	$linhas = NumeroLinhas($primeiro_dia_do_mes, $dias_no_mes);

	for($i = 1; $i <= $linhas ; $i++){

	?>

    <tr>

		<?php for($j = 1; $j <= 7; $j++){?>

        <td>

        

        	<?php



				if($i==1){

					if($j > $flag){	

						if($day == date("j")){

							VerificaEvento($day++);

						}

						else{

							VerificaEvento($day++);					

						}

					}

				}

				// Se i for maior que 2

				else{

					if($day <= $dias_no_mes){



							VerificaEvento($day++);



					}

				}

	

			?>	 



        </td> 

        <?php } ?>   

    </tr>

    <?php } ?>

    <!-- FIM COLUNAS DIAS -->



    <tr>

    	<td colspan="7" class="menu">

		

        	<?





				if( $anterior_mes >= 1 ){

					echo "<a href='javascript:Ajax(".$anterior_mes.",". $ano.");' >&laquo;&nbsp;</a>";

					$mes = $anterior_mes;

				}

				else{

					$anterior_mes = 12;

					echo "<a href='javascript:Ajax(".$anterior_mes.",". $ano.");' >&laquo;&nbsp;</a>";

					$mes = $anterior_mes;

				}





				echo Menu();



				if( $proximo_mes <= 12 ){

					echo "<a href='javascript:Ajax(".$proximo_mes.",". $ano.");' >&nbsp;&raquo;</a>";

					$mes = $proximo_mes;



				}

				else{

					$proximo_mes = 1;

					echo "<a href='javascript:Ajax(".$proximo_mes.",". $ano.");' >&nbsp;&raquo;</a>";

					$mes = $proximo_mes;

				}



             //echo ' <br />  <a href="evm,'.$mes-1.',eventos-do-site-pontinha-de-sol.html">veja mais [+]</a><br /> ';



			?>

            <br /><a href="evm,<?echo $mes-1?>,eventos-do-site-pontinha-de-sol.html">veja mais [+]</a>





        </td>

    </tr>



</table>



</div>

