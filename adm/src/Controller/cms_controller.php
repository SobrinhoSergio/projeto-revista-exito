<?php

use Friweb\CMS\Model\User;

// verifica sessão
session_start();
isSessionValid();

//pega o nome do usuário
$userName = User::getArraySelect(['chave_usuario' => $_SESSION['id']], 'nome_usuario');

//carrega a View com o nome do usuário salvo em uma variável
loadView('cms_main', $userName[0]);
