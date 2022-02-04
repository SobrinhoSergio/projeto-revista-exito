<?php

    // Pegando o IP 

    if (getenv(HTTP_X_FORWARDED_FOR))
    { 
      $ip=getenv(HTTP_X_FORWARDED_FOR); 
    }
    else 
    { 
      $ip=getenv(REMOTE_ADDR);
    } 

    $ip_visitante = $ip;

    $ip_visitante = $ip_visitante . " - " . gethostbyaddr ($ip_visitante);




    // Pegando a Data e Hora

    $data_hora_visitante = date("d") . "/" . date("m") . "/" . date("Y") . " - " . date("H") . ":" . date("i");

    // $email_destinatario = $_REQUEST['email_area'];

    $email_destinatario = 'ayrton@exitorio.com.br';


    $mensagem = "Nome: " . $_REQUEST['nome_visitante'] . "\n\n";
    $mensagem = $mensagem . "Email: " . $_REQUEST['email_visitante'] . "\n\n";
    $mensagem = $mensagem . "Mensagem: " . $_REQUEST['mensagem_visitante'] . "\n\n";
    $mensagem = $mensagem . "IP: " . $ip_visitante . "\n\n";
    $mensagem = $mensagem . "Data / Hora: " . $data_hora_visitante . "\n\n";


    $destinatario = "Revista Êxito Rio <" . $email_destinatario . ">";
    $titulo = "Contato - Revista Êxito Rio";
    $remetente = "From:" . $_POST['nome_visitante'] . "<" . $_POST['email_visitante'] . ">\nContent-type: text/plain\n";

    mail($destinatario,$titulo,$mensagem,$remetente);


    header("Location: conteudo.php?conteudo=contato-ok");  

?>