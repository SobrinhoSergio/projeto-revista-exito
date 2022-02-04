<?php

//data e linguagem
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

// constantes
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../Model/'));
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../View/'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../Controller/'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../AppException/'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../View/template'));



// carrega arquivos na camada View junto a possíveis variáveis e exceções
function loadView($viewname = null, $params = array(), $exception = array()) {

    //caminho até o diretório da camada View
    $fullPath = (VIEW_PATH . '/' . $viewname . '.php');

    // se parâmetros forem passados na array, cada valor será uma variável de mesmo nome
    // ${$key} é exportada
    if (count($params) > 0) {
      foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    // $exceptionsArray é exportada
    if (isset($exception)) {
        $exceptionsArray = $exception;
    }
    
    // carrega o arquivo da camada View
    if(file_exists($fullPath)) {
        require_once $fullPath;
    }    
}

// redimensiona e move imagens
function resize($file, $extension, $width, $height, $destination) {

    switch ($extension){
        case 'jpg':
        case 'jpeg':
            // create new jpeg img
            $tmp_img = imagecreatefromjpeg($file);

            // set original w/h
            $original_width = imagesx($tmp_img);
            $original_height = imagesy($tmp_img);

            // create new img id with new w/h values
            $new_img = imagecreatetruecolor($width, $height);

            // copy and resize img
            imagecopyresampled($new_img, $tmp_img, 0, 0, 0, 0, $width, $height, $original_width, $original_height);

            // send new img to destination
            imagejpeg($new_img, $destination);
            break;

        case 'png':
            $tmp_img = imagecreatefrompng($file);
            $original_width = imagesx($tmp_img);
            $original_height = imagesy($tmp_img);
            $new_img = imagecreatetruecolor($width, $height);
            imagecopyresampled($new_img, $tmp_img, 0, 0, 0, 0, $width, $height, $original_width, $original_height);
            imagepng($new_img, $destination);
            break;

        case 'gif':
            $tmp_img = imagecreatefromgif($file);
            $original_width = imagesx($tmp_img);
            $original_height = imagesy($tmp_img);
            $new_img = imagecreatetruecolor($width, $height);
            imagecopyresampled($new_img, $tmp_img, 0, 0, 0, 0, $width, $height, $original_width, $original_height);
            imagegif($new_img, $destination);
            break;
    }
}