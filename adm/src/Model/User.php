<?php

namespace Friweb\CMS\Model;

use Friweb\CMS\AppException\AppException;

class User extends Model implements Image {

    // nome da tabela no banco de dados
    protected static $table = 'tabela_usuarios';

    // colunas
    protected static $columns = [
        'chave_usuario',
        'nome_usuario',
        'email_usuario',
        'senha_usuario',
        'tipo_usuario',
        'bio_usuario',
        'ativo',
        'publicar',
    ];


    // cria um usuário
    public function createUser() {

        // abre conexão com banco de dados
        $cnn = Database::getConnection();

        // recebe a senha digitada no cadastro e encriptografa
        $pass = $this->password;
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

        // salva os parâmetros recebidos pelo formulário numa array
//        $params = array($this->name, $this->email, $hashed_password, $this->type, $this->publish, $this->bio);
        
        // salva no banco de dados
        $sql = "INSERT INTO tabela_usuarios (nome_usuario, email_usuario, senha_usuario, publicar) VALUES (?,?,?,?)";
        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("sssi", $this->name, $this->email, $hashed_password, $this->publish);

        // valida inserções no formulário
        if ( (strlen($this->name) <= 1) || !(filter_var($this->email, FILTER_VALIDATE_EMAIL)) || ($this->password == '') || !$result) {
            throw new AppException("Algo deu errado. Por favor, tente novamente.");
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        return self::getArraySelect(['email_usuario' => $this->email],'chave_usuario');
    }

    public function update($key, $field = [])
    {
        if (count($field) > 0) {
            // senha
            foreach ($field as $index => $value) {
                $sql = "UPDATE tabela_usuarios SET ". $index . " =  (?)" . " WHERE chave_usuario = ". $key;
                $cnn = Database::getConnection();
                $stmt = $cnn->prepare($sql);
                $hashed_password = password_hash($value, PASSWORD_DEFAULT);
                $stmt->bind_param("s", $hashed_password);
                $stmt->execute();
                $cnn->close();
                $stmt->close();
            }
            return $key;
        }

        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_usuarios SET nome_usuario = (?), email_usuario = (?), ativo = (?), publicar = (?) WHERE chave_usuario = " . $key;

//        $params = array($this->name, $this->email, $this->type, $this->active, $this->publish, $this->bio);
        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("ssii", $this->name, $this->email, $this->active, $this->publish);

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

        // verifica tamanho máximo da imagem
        if (self::getDimensions($img)['width'] > 4300 || self::getDimensions($img)['height'] > 3000) {
            throw new AppException('Tamanho de imagem inválido. Por favor, tente novamente.');
        }

        // nome temporário
        $tmp_name = 'assets/img/' . $dir . uniqid() . '.png';

        // salva imagem
        file_put_contents($tmp_name, $img);

        chmod($tmp_name, 0644);

        // retorna caminho a imagem temporária
        return $tmp_name;
    }

    function getDimensions($img)
    {
        // TODO: Implement getDimensions() method.
    }

    function renameImg($key, $tmp, $ext, $dir = '')
    {
        $newName = dirname("../../materia.php"). '/img/' . $dir . $key . '.' . $ext;

        // move a imagem
        rename($tmp, $newName);

        // retorna caminho
        return '/img/' . $dir . $key . '.' . $ext;
    }

    function checkDimensions($img)
    {

    }
}