<?php


namespace Friweb\CMS\Model;


use Friweb\CMS\AppException\AppException;

class CategoryPartner extends Model
{
    protected static $table = 'tabela_categoria_guia';

    protected static $columns = [
        'chave_categoria',
        'nome_categoria',
        'ativo',
        'publicar'
    ];

    public function insert()
    {
        $cnn = Database::getConnection();
        $sql = "INSERT INTO tabela_categoria_guia (nome_categoria, publicar) VALUES (?,?)";

        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("si", $this->name,  $this->publish);

        if (!$result) {
            throw new AppException('Algo deu errado. Por favor, cheque os campos inseridos.');
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        return self::getArraySelect(['nome_categoria' => $this->name],'chave_categoria');
    }

    public function update($key)
    {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_categoria_guia SET nome_categoria = (?), publicar = (?), ativo = (?) WHERE chave_categoria = " . $key;

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("sii", $this->name, $this->publish, $this->active);

        $res = $stmt->execute();
        if (!$res) {
            throw new AppException('Algo deu errado. Por favor, verifique os campos inseridos.');
        }

        $stmt->close();
        $cnn->close();
    }
}