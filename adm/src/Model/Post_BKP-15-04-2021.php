<?php

namespace Friweb\CMS\Model;

use DateTime;
use Friweb\CMS\AppException\AppException;

class Post extends Model implements Image {

	protected static $table = 'tabela_materias';

    protected static $columns = [
        'chave_materia',
        'titulo_materia',
        'subtitulo_materia',
        'introducao_materia',
        'autor_materia',
        'data_materia',
        'validade_materia',
        'texto_materia',
        'tipo_materia',
        'tema_materia',
        'categoria_especial_materia',
        'servico_materia',
        'imagem_servico_materia',
        'coluna_materia',
        'acessos_materia',
        'ativo',
        'publicar',
    ];

    public function insertPost()
    {
        $cnn = Database::getConnection();

        $date = new DateTime();
        $dataFormat = $date->format('d-m-Y H:i:s');

        if ($this->type == 2 && $this->expiration != 0) {
            $expirationDateTime = self::formatExpirationDate($this->expiration);
        }

        $author = $this->writer;

        $sql = "INSERT INTO tabela_materias (titulo_materia, subtitulo_materia, autor_materia, data_materia, tipo_materia, publicar, texto_materia, introducao_materia, servico_materia, tema_materia, categoria_especial_materia, coluna_materia, validade_materia) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $cnn->prepare($sql);

        $result = $stmt->bind_param("ssssiissssiis", $this->title, $this->subtitle, $author, $dataFormat, $this->type, $this->publish, $this->main, $this->intro, $this->service_text, $this->subject, $this->category, $this->column, $expirationDateTime);

        if (!$result) {
            throw new AppException('Parâmetros inválidos. Por favor, cheque os campos inseridos.');
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        return self::getArraySelect(['titulo_materia' => $this->title],'chave_materia');

    }

    private static function formatExpirationDate($months) {
        $date = new DateTime('now');
        $date->modify('+'.$months .'month');

        return $date->format('Y-m-d H:i:s');
    }

    public function insertImageSubtitle($key, $index, $value) {
        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_materias SET ". $index . " = (?) WHERE chave_materia = " . $key;
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("s", $value);
        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }
        $stmt->close();
        $cnn->close();

    }


    public function update($key, $field = [])
    {
        if ($field != []) {
            foreach ($field as $index => $value) {
                $sql = "UPDATE tabela_materias SET ". $index . " = " . $value . " WHERE chave_materia = ". $key;
                return Database::getResultFromQuery($sql);
            }
        }

        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_materias SET titulo_materia = (?), subtitulo_materia = (?), introducao_materia = (?), autor_materia = (?), texto_materia = (?), tipo_materia = (?), publicar = (?), servico_materia = (?), ativo = (?), tema_materia = (?), categoria_especial_materia = (?), coluna_materia = (?) WHERE chave_materia = " . $key;
        
        if ($this->type == 2 && $this->expiration != 0) {
            Database::getResultFromQuery("validade_materia = DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL (".$this->expiration.") MONTH) WHERE chave_materia = " . $key);
        }

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("sssssiisisii", $this->title, $this->subtitle, $this->intro, $this->writer, $this->main, $this->type, $this->publish, $this->service_text, $this->active, $this->subject, $this->category, $this->column);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }
        $stmt->close();
        $cnn->close();
    }

    function moveImage($dir)
    {
        // decodifica a imagem em base 64
        $image_array_1 = explode(";", $this->image);
        $image_array_2 = explode(",", $image_array_1[1]);
        $img = base64_decode($image_array_2[1]);

        if (self::getDimensions($img)['width'] > 4300 || self::getDimensions($img)['height'] > 3000) {
            throw new AppException('Tamanho de imagem inválido. Por favor, tente novamente.');
        }

        $tmp_name = 'assets/img/' . $dir . uniqid() . '.png';

        file_put_contents($tmp_name, $img);

        return array('tmp_name' => $tmp_name);
    }

    function getDimensions($img)
    {
        $img = $this->image;
        list($width, $height) = getimagesize($img);
        return ['width' => $width, 'height' => $height];
    }

    function renameImg($key, $tmp, $ext, $dir = '', $extra = 0)
    {

        $newName = dirname("../../materia.php"). '/img/posts/' . $dir . $key;

        if ($ext != '') {
            $newName .= '.' . $ext;
        }
        rename($tmp, $newName);

        if ($extra != 0) {
            try {
                self::insertImagePath('/img/posts/' . $dir . $key . '.' . $ext, $extra, $key);
            } catch (AppException $e) {
                $e = "erro";
            }
            chmod($newName, 0644);
        }

        return $newName;
    }

    private function insertImagePath($path, $n, $key) {

        switch ($n) {
            case 2:
                $column = 'imagem_extra_secundaria';
                break;
            case 3:
                $column = 'imagem_extra_terciaria';
                break;
            case 4:
                $column = 'imagem_extra_quaternaria';
                break;
            case 5:
                $column = 'imagem_servico_materia';
                break;
        }
        $primaryKey = explode("_", $key);

        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_materias SET ". $column ." = (?) WHERE chave_materia = " . $primaryKey[0];
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

    public function incrementViews($key)
    {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_materias SET acessos_materia = acessos_materia + 1 WHERE chave_materia = ${key}";
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("i", $key);
        $stmt->execute();

        $stmt->close();
        $cnn->close();
    }

    public function getPostsByDate($filters = [])
    {
        $cnn = Database::getConnection();
        $sql = "SELECT * FROM tabela_materias WHERE ativo = 1 AND publicar = 1";

        if ($filters != []) {
            $sql .= " AND (";
            foreach ($filters as $index => $value) {
                $sql .= " ${index} = ${value} or";
            }
            $sql .= " 1 = 0)";
        }

        $sql.= " ORDER BY DATE_FORMAT(str_to_date(data_materia, '%d-%m-%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s') DESC";
        return Database::getResultFromQuery($sql);
    }

    public function getPaidPostsByDate($filter) {
        $cnn = Database::getConnection();
        $sql = "SELECT * FROM tabela_materias WHERE ativo = 1 AND publicar = 1 AND tipo_materia = 2";

        if ($filter != []) {
            $sql .= " AND (";
            foreach ($filter as $index => $value) {
                $sql .= " ${index} = ${value} or";
            }
            $sql .= " 1 = 0)";
        }

        $sql.= " ORDER BY DATE_FORMAT(str_to_date(data_materia, '%d-%m-%Y %H:%i:%s'), '%Y-%m-%d %H:%i:%s') DESC";
        return Database::getResultFromQuery($sql);

    }

    public function repost($key)
    {
        $date = new DateTime();
        $dataFormat = $date->format('d-m-Y H:i:s');

        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_materias SET data_materia = '". $dataFormat."' WHERE chave_materia = " . $key;
        return Database::getResultFromQuery($sql);
    }

    public static function searchPosts($filter) {

        $filterLower = mb_strtolower($filter);
        $filterUpper = mb_strtoupper($filter);
        
        $sql = "SELECT * FROM tabela_materias WHERE (LOWER(titulo_materia) LIKE LOWER('%". $filterLower."%') OR 
        UPPER(titulo_materia) LIKE UPPER('%". $filterUpper."%') OR

        LOWER(subtitulo_materia) LIKE LOWER('%".$filterLower."%') OR
        UPPER(subtitulo_materia) LIKE UPPER('%".$filterUpper."%') OR

        LOWER(autor_materia) LIKE LOWER('%".$filterLower."%') OR
        UPPER(autor_materia) LIKE UPPER('%".$filterUpper."%') OR

        LOWER(tema_materia) LIKE LOWER('%".$filterLower."%') OR
        UPPER(tema_materia) LIKE UPPER('%".$filterUpper."%') OR

        data_materia LIKE '%".$filter."%') AND (ativo = 1 AND publicar = 1) ORDER BY chave_materia DESC";
        return Database::getResultFromQuery($sql);
    }
    
    public static function postTitleIsUnique($title) {

        $connection = Database::getConnection();
        $sql = "SELECT * FROM tabela_materias WHERE titulo_materia = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("s", $title);
        $statement->execute();
        $result = $statement->get_result();
        $post = $result->fetch_array(MYSQLI_ASSOC);
        $result->close();
        $statement->close();
        $connection->close();

        if (count($post) > 0) {
            throw new AppException("Já existe uma matéria com este título.");
        } 

    }

}