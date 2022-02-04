<?php


namespace Friweb\CMS\Model;


use Friweb\CMS\AppException\AppException;
use DateTime;

class Partner extends Model implements Image
{
    protected static $table = 'tabela_guia';

    protected static $columns = [
        'chave_empresa',
        'nome_empresa',
        'chave_categoria',
        'imagem_guia',
        'vencimento_guia',
        'ativo',
        'publicar',
        'link_guia'
    ];

    public function insertPartner()
    {

        $cnn = Database::getConnection();

        $sql = "INSERT INTO tabela_guia (nome_empresa, chave_categoria, publicar, vencimento_guia, link_guia) VALUES (?,?,?,?,?)";

        $expirationDate = self::formatExpirationDate($this->expiration);

        $stmt = $cnn->prepare($sql);
        $result = $stmt->bind_param("siiss", $this->name, $this->category, $this->publish, $expirationDate, $this->link);

        if (!$result) {
            throw new AppException('Algo deu errado. Por favor, cheque os campos inseridos.');
        }

        $stmt->execute();

        $stmt->close();
        $cnn->close();

        // retorna primary key onde nome da empresa no db == nome passado no formulário
        return self::getArraySelect(['nome_empresa' => $this->name], 'chave_empresa');
    }

    private static function formatExpirationDate($months) {
        $date = new DateTime('now');
        $date->modify('+'.$months .'month');

        return $date->format('Y-m-d');
    }

    public function update($key)
    {
        $cnn = Database::getConnection();

        $sql = "UPDATE tabela_guia SET nome_empresa = (?), chave_categoria = (?), publicar = (?), ativo = (?), link_guia = (?) WHERE chave_empresa = " . $key;
        
        if ($this->expiration != 0) {
            Database::getResultFromQuery("UPDATE tabela_guia SET vencimento_guia = DATE_ADD(CURRENT_DATE(), INTERVAL (".$this->expiration.") MONTH) WHERE chave_empresa = " . $key);
        }

        $stmt = $cnn->prepare($sql);
        $stmt->bind_param("siiis", $this->name, $this->category, $this->publish, $this->active, $this->link);

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

        // retorna caminho a imagem temporária
        return $tmp_name;
    }

    function getDimensions($img)
    {
        $img = $this->image;
        list($width, $height) = getimagesize($img);
        return ['width' => $width, 'height' => $height];
    }

    function renameImg($key, $tmp, $ext, $dir = '')
    {
        $newName = dirname("../../materia.php"). '/img/' . $dir . $key. '.' . $ext;

        // move a imagem
        rename($tmp, $newName);

        // retorna caminho
        return $newName;
    }

    function checkDimensions($img)
    {
        list($w, $h) = getimagesize($img);

        if ($w < 220 || $h < 143) {
            throw new AppException("Imagem muito pequena. Mínimo: 220x143px; máximo: 1400x1060px");
        }

        if ($w > 1400 || $h > 1060) {
            throw new AppException("Imagem muito grande. Máximo: 1400x1060px; mínimo: 220x143px");
        }

        return true;
    }

    public function getPartners($category)
    {
        if (!is_int($category)) {
            return null;
        }
        Database::getConnection();
        $sql = "SELECT chave_empresa, imagem_guia, link_guia, nome_empresa FROM tabela_guia WHERE ativo = 1 AND publicar = 1 AND chave_categoria = ".$category." ORDER BY chave_empresa DESC";
        return Database::getResultFromQuery($sql);
    }

    public function insertImageLink($path, $key) {
        $sql = "UPDATE tabela_guia SET imagem_guia = '${path}' WHERE chave_empresa = ${key}";
        Database::getResultFromQuery($sql);
    }

}