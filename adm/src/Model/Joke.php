<?php


namespace Friweb\CMS\Model;


use DateTime;
use Friweb\CMS\AppException\AppException;

class Joke extends Model implements Image
{
    protected static $table = 'tabela_piadas';

    protected static $columns = [
      'chave_piada',
      'titulo_piada',
      'texto_piada',
      'data_piada',
      'imagem_piada',
      'ativo',
      'publicar',
    ];

    public function insertJoke()
    {
        $cnn = Database::getConnection();

        $date = new DateTime();
        $dataFormat = $date->format('d-m-Y H:i:s');

//        $params = array($this->title, $this->main, $dataFormat, $this->writer, $this->publish);

        $sql = "INSERT INTO tabela_piadas (titulo_piada, texto_piada, data_piada, publicar) VALUES (?,?,?,?)";
        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("sssi", $this->title, $this->main, $dataFormat, $this->publish);
        if (!$result) {
            throw new AppException('Erro! Por favor, cheque os campos inseridos.');
        }
        $stmt->execute();
        $stmt->close();
        $cnn->close();

        return self::getArraySelect(['titulo_piada' => $this->title],'chave_piada');
    }


    public function update($key) {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_piadas SET titulo_piada = (?), texto_piada = (?), ativo = (?), publicar = (?) WHERE chave_piada = " . $key;

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("ssii", $this->title, $this->main, $this->active, $this->publish);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }

        $stmt->close();
        $cnn->close();
    }

    function moveImage($dir)
    {
        // TODO: Implement moveImage() method.
    }

    function getDimensions($img)
    {
        // TODO: Implement getDimensions() method.
    }

    function renameImg($key, $tmp, $ext, $dir = '')
    {
        $newName = dirname("../../materia.php"). '/img/diversao/' . $key . '.' . $ext;

        // move a imagem
        rename($tmp, $newName);

        // insere caminho no db
        try {
            self::insertImagePath('/img/diversao/' . $key . '.' . $ext, $key);
        } catch (AppException $e) {
            $e = "erro";
        }
        chmod($newName, 0644);

        // retorna caminho
        return $newName;
    }

    private function insertImagePath($path, $key) {

        $column = 'imagem_piada';

        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_piadas SET ". $column ." = (?) WHERE chave_piada = " . $key;
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("s", $path);
        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }
        $stmt->close();
        $cnn->close();
    }

    function checkDimensions($img)
    {
        list($width, $height) = getimagesize($img);

        if (!($width <= 4300 || $height <= 3000)) {
            throw new AppException('Tamanho máximo de imagem excedido');
        }
    }
}