<?php


namespace Friweb\CMS\Model;


use Friweb\CMS\AppException\AppException;



class TemaMateria extends Model
{
    protected static $table = 'tabela_categoria_noticia';

    protected static $columns = [
        'chave_tipo',
        'tema_materia',
        'ativo',
        'publicar'
    ];

    public function insert()
    {
        $cnn = Database::getConnection();
        $sql = "INSERT INTO tabela_categoria_noticia (tema_materia, publicar, ativo) VALUES (?,?,1)";

        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("si", $this->name,  $this->publish);

        if (!$result) {
            throw new AppException('Algo deu errado. Por favor, cheque os campos inseridos.');
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        return self::getArraySelect(['tema_materia' => $this->name], 'chave_tipo');
    }

    public function update($key)
    {
        $cnn = Database::getConnection();
        $sql = "UPDATE tabela_categoria_noticia SET tema_materia = (?), publicar = (?), ativo = 1 WHERE chave_tipo = " . $key;
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("si", $this->name, $this->publish);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }

        $stmt->close();
        $cnn->close();
    }
}
