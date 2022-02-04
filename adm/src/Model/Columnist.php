<?php


namespace Friweb\CMS\Model;


use Friweb\CMS\AppException\AppException;

class Columnist extends Model implements Image
{

    protected static $table = 'tabela_colunistas';

    protected static $columns = [
        'chave_colunista',
        'nome_colunista',
        'bio_colunista',
        'foto_colunista',
        'categoria_colunista',
        'ativo',
        'publicar'
    ];


    public function insertColumnist()
    {
        $cnn = Database::getConnection();

        $sql = "INSERT INTO tabela_colunistas (nome_colunista, bio_colunista, categoria_colunista, publicar) VALUES (?,?,?,?)";

        $stmt = $cnn->prepare($sql);

        $result = $stmt->bind_param("sssi", $this->name, $this->bio, $this->category, $this->publish);

        if (!$result) {
            throw new AppException("Parâmetros inválidos. Por favor, cheque os campos inseridos.");
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        $keyArray = self::getArraySelect(['categoria_colunista' => $this->category], 'chave_colunista');

        return $keyArray[0]['chave_colunista'];

    }

    public function update($key)
    {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_colunistas SET nome_colunista = (?), bio_colunista = (?), categoria_colunista = (?), ativo = (?), publicar = (?) WHERE chave_colunista = ${key}";

        $stmt = $cnn->prepare($sql);

        $stmt->bind_param("sssii", $this->name, $this->bio, $this->category, $this->active, $this->publish);

        $res = $stmt->execute();

        if (!$res) {
            throw new AppException("Algo deu errado. Por favor, tente novamente");
        }
        $stmt->close();
        $cnn->close();

    }

    public function insertImageLink($path, $key) {
        $sql = "UPDATE tabela_colunistas SET foto_colunista = '${path}' WHERE chave_colunista = ${key}";
        Database::getResultFromQuery($sql);
    }

    function moveImage($dir)
    {
        // decodifica a imagem em base 64
        $image_array_1 = explode(";", $this->image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);

        $tmp_name = 'assets/img/' . $dir . uniqid() . '.png';

        file_put_contents($tmp_name, $img);

        return $tmp_name;
    }

    function getDimensions($img)
    {
        // TODO: Implement getDimensions() method.
    }

    function renameImg($key, $tmp, $ext, $dir = '')
    {
        $newName = dirname("../../materia.php"). '/img/colunistas/' . $dir . $key;

        if ($ext != '') {
            $newName .= '.' . $ext;
        }

        rename($tmp, $newName);

        return '/img/colunistas/' . $dir . $key . '.' . $ext;
    }

    function checkDimensions($img)
    {
        list($width, $height) = getimagesize($img);

        if (!($width <= 4300 || $height <= 3000)) {
            throw new AppException('Tamanho máximo de imagem excedido');
        }
    }

    public function resize_image($file, $newName)
    {

        $image = imagecreatefromjpeg($file);
        $filename = $newName;

        $thumb_width = 180;
        $thumb_height = 180;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect ) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled($thumb, $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height, $width, $height);

        imagejpeg($thumb, dirname("../../materia.php"). $filename, 72);

    }
}