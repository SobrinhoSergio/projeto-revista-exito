<?php


namespace Friweb\CMS\Model;

use AppendIterator;
use DateTime;
use Friweb\CMS\AppException\AppException;

class Sponsor extends Model implements Image
{
    protected static $table = 'tabela_anuncios';

    protected static $columns = [
        'chave_anuncio',
        'empresa_anuncio',
        'descricao_anuncio',
        'imagem_anuncio',
        'link_anuncio',
        'tipo_anuncio',
        'data_ultima_renovacao',
        'vencimento_anuncio',
        'insercao_anuncio',
        'acessos',
        'ativo',
        'publicar'
    ];

    public function insertSponsor()
    {
        $cnn = Database::getConnection();

        $date = new DateTime('now');

        $currentDate = new DateTime('now');
        $currentDate = $currentDate->format('Y-m-d');


        if ($_POST['expiration'] != 0) {
            $date->modify('+' . $this->expiration . 'month');
            $exp_date = $date->format('Y-m-d');
        } else {
            $exp_date = null;
        }

        $publish = 1;
        $acessos = 0;
        $sql = "INSERT INTO tabela_anuncios (descricao_anuncio, tipo_anuncio, publicar, link_anuncio, vencimento_anuncio, insercao_anuncio,acessos) VALUES (?,?,?,?,?,?,?)";

        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("siisssi", $this->description, $this->type, $publish, $this->link, $exp_date, $currentDate, $acessos);

        if (!$result) {
            throw new AppException('Algo deu errado. Por favor, cheque os campos inseridos.');
        }

        if (!$stmt->execute()) {
            throw new AppException($stmt->error);
        }

        $stmt->close();
        $cnn->close();

        $queryResult = self::getArraySelect(['descricao_anuncio' => $this->description, 'tipo_anuncio' => $this->type, 'vencimento_anuncio' => $exp_date], 'chave_anuncio');
        return $queryResult[0]['chave_anuncio'];
    }

    public function update($key)
    {

        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_anuncios SET descricao_anuncio = (?), publicar = (?), ativo = (?), link_anuncio = (?) WHERE chave_anuncio = " . $key;


        if ($this->expiration != 0) {
            Database::getResultFromQuery("UPDATE tabela_anuncios SET data_ultima_renovacao = CURRENT_DATE(), vencimento_anuncio = DATE_ADD(CURRENT_DATE(), INTERVAL (" . $this->expiration . ") MONTH) WHERE chave_anuncio = " . $key);
        }


        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("siis", $this->description, $this->publish, $this->active, $this->link);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }

        $stmt->close();
        $cnn->close();
    }

    public function insertImageLink($path, $key)
    {
        $sql = "UPDATE tabela_anuncios SET imagem_anuncio = '${path}' WHERE chave_anuncio = ${key}";
        Database::getResultFromQuery($sql);
    }

    public function moveImage($dir)
    {
        // decodifica a imagem em base 64
        $image_array_1 = explode(";", $this->image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);

        if (self::getDimensions($img)['width'] > 4300 || self::getDimensions($img)['height'] > 3000) {
            throw new AppException('Tamanho de imagem inválido. Por favor, tente novamente.');
        }

        $tmp_name = 'assets/img/' . $dir . uniqid() . '.jpg';
        file_put_contents($tmp_name, $img);

        return $tmp_name;
    }

    public function getDimensions($img)
    {
        $img = $this->image;
        list($width, $height) = getimagesize($img);
        return ['width' => $width, 'height' => $height];
    }

    public function renameImg($key, $tmp, $ext, $dir = '')
    {
        if ($dir != '') {
            $dir = self::getDirectoryByType();
        }

        $newName =  dirname("../../materia.php") . '/img/anuncios/' . $dir . $key . '.' . $ext;

        rename($tmp, $newName);

        return '/img/anuncios/' . $dir . $key . '.' . $ext;
    }

    public function checkDimensions($img)
    {
        list($width, $height) = getimagesize($img);

        if (!($width <= 4300 || $height <= 3000)) {
            throw new AppException('Tamanho máximo de imagem excedido');
        }
    }

    public function getDirectoryByType()
    {
        switch ($this->type) {
            case 1;
            case 2;
            case 3;
                return 'banner/';
            case 4;
            case 5;
            case 6;
                return 'retangulo/';
            case 7;
            case 8;
                return 'modal/';
            case 9;
            case 10;
                return 'logo/';
            case 12;
            case 13;
                return 'imovel/';
            case 15;
                return 'slide/';
            default;
                return 'full/';
        }
    }

    public function getRandom($limit, $filters = [])
    {
        $sql = "SELECT * FROM tabela_anuncios WHERE publicar = 1 AND ativo = 1";
        if ($filters != []) {
            $sql .= " AND 1=1";
            foreach ($filters as $index => $value) {
                $sql .= " AND $index = $value";
            }
        }
        $sql .= " ORDER BY RAND() DESC LIMIT " . $limit;
        return Database::getResultFromQuery($sql);
    }

    public function getDimensionsByType()
    {
        switch ($this->type) {
            case 1;
            case 2;
            case 3;
                return ['width' => 970, 'height' => 90];
            case 4;
            case 5;
            case 6;
                return ['width' => 300, 'height' => 250];
            case 7;
            case 8;
                return ['width' => 490, 'height' => 410];
            case 9;
            case 10;
                return ['width' => 150, 'height' => 150];
            case 12;
            case 13;
                return ['width' => 406, 'height' => 305];
            case 15;
                return ['width' => 1580, 'height' => 645];
            default;
                return ['width' => 1200, 'height' => 400];
        }
    }

    public function resize_image($file, $newName, $w, $h)
    {
        $image = imagecreatefromstring(file_get_contents($file));

        $filename = $newName;

        $thumb_width = $w;
        $thumb_height = $h;

        list($width, $height) = getimagesize($file);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

        imagecopyresampled(
            $thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0,
            0,
            $new_width,
            $new_height,
            $width,
            $height
        );

        try {
            imagejpeg($thumb, dirname("../../materia.php") . $filename, 72);
        } catch (AppException $e) {
            echo $e;
        }
    }

    public function incrementViews($key)
    {
        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_anuncios SET acessos = acessos + 1 WHERE chave_anuncio = " . $key;
        $stmt = $cnn->prepare($sql);
        $stmt->execute();

        $stmt->close();
        $cnn->close();
    }

    public function unpublish($key)
    {

        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_anuncios SET publicar = 0 WHERE chave_anuncio = (?)";

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("i", $key);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }
    }

    public static function republishSlideshow($link)
    {

        $cnn = Database::getConnection();

        $date = new DateTime('now');

        $date = new DateTime('now');
        $date->modify('+1month');
        $date = $date->format('Y-m-d');

        $sql = "UPDATE tabela_anuncios SET ativo = 1, publicar = 1, data_ultima_renovacao = CURRENT_DATE(), vencimento_anuncio = (?) WHERE link_anuncio = (?)";

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("ss", $date, $link);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }
    }

    public static function getSponsorDimensions($type)
    {
        switch ($type) {
            case 1;
            case 2;
            case 3;
                return ['width' => 970, 'height' => 90];
            case 4;
            case 5;
            case 6;
                return ['width' => 300, 'height' => 350];
            case 7;
            case 8;
                return ['width' => 490, 'height' => 410];
            case 9;
            case 10;
                return ['width' => 150, 'height' => 150];
            case 12;
            case 13;
                return ['width' => 406, 'height' => 305];
            case 15;
                return ['width' => 1580, 'height' => 645];
            default;
                return ['width' => 1200, 'height' => 400];
        }
    }

    public static function getSponsorDirectory($type)
    {
        switch ($type) {
            case 1;
            case 2;
            case 3;
                return 'banner/';
            case 4;
            case 5;
            case 6;
                return 'retangulo/';
            case 7;
            case 8;
                return 'modal/';
            case 9;
            case 10;
                return 'logo/';
            case 12;
            case 13;
                return 'imovel/';
            case 15;
                return 'slide/';
            default;
                return 'full/';
        }
    }
}
