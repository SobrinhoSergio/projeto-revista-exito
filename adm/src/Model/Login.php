<?php


namespace Friweb\CMS\Model;

use Friweb\CMS\AppException\AppException;

class Login extends Model {

	// verifica login no sistema
    public function checkLogin() {

    	// retorna a linha na tabela
        $user = User::getRow(['email_usuario' => $this->email]);

        if ($user) {
            if(password_verify($this->password, $user->senha_usuario)) {
                return $user;
            }
        }

        throw new AppException('Login inválido');
    }
}