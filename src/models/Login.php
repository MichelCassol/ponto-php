<?php 
class Login extends Model
{
	public function validate()
	{
		$errors = [];

		if (!$this->email) {
			$errors['email'] = "E-mail é um campo obrigatório.";
		}

		if (!$this->password) {
			$errors['password'] = "Por favor, informe a senha.";
		}

		if (count($errors) > 0) {
			throw new ValidationExceptions($errors);
		}
	}
    public function checkLogin()
    {
		$this->validate();
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
