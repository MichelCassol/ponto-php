<?php 

class Login extends Model
{
    public function checkLogin()
    {
        $user = User::getOne(['email' => $this->email]);

		if ($user->end_date) {
			throw new AppExceptions('Usuário está desligado da empresa.');
		}

        if($user) {
            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppExceptions('Usuário e Senha inválidos.');
    }
}
