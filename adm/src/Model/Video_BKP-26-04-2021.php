<?php


namespace Friweb\CMS\Model;


use DateTime;
use Friweb\CMS\AppException\AppException;

class Video extends Model
{
    protected static $table = 'tabela_videos';

    protected static $columns = [
        'chave_video',
        'titulo_video',
        'descricao_video',
        'tema_video',
        'link_video',
        'data_video',
        'acessos_video',
        'ativo',
        'publicar'
    ];

    public function insertVideo()
    {
        $cnn = Database::getConnection();

        $date = new DateTime();
        $dataFormat = $date->format('d-m-Y H:i:s');

//        $params = array($this->title, $this->description, $this->subject, $this->link, $dataFormat, $this->publish);

        $sql = "INSERT INTO tabela_videos (titulo_video, descricao_video, tema_video, link_video, data_video, publicar) VALUES (?,?,?,?,?,?)";

        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("sssssi", $this->title, $this->description, $this->subject, $this->link, $dataFormat, $this->publish);

        if (!$result) {
            throw new AppException('Parâmetros inválidos. Por favor, cheque os campos inseridos.');
        }

        $resultExec = $stmt->execute();

        if (!$resultExec) {
            throw new AppException('Link de vídeo já existente no banco de dados!');
        }

        $stmt->close();
        $cnn->close();

    }

    public function incrementViews($key)
    {
        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_videos SET acessos_video = acessos_video + 1 WHERE chave_video = ".$key;
        $stmt = $cnn->prepare($sql);
        $stmt->execute();

        $stmt->close();
        $cnn->close();
    }

    public function update($key)
    {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_videos SET titulo_video = (?), descricao_video = (?), tema_video = (?), link_video = (?), ativo = (?), publicar = (?) WHERE chave_video = " . $key;

//        $params = array($this->title, $this->description, $this->subject, $this->link, $this->active, $this->publish);
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("ssssii", $this->title, $this->description, $this->subject, $this->link, $this->active, $this->publish);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }

        $stmt->close();
        $cnn->close();
    }
}