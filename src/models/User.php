<?php 
class User extends Model
{
    protected static $tableName = 'users';
    protected static $coluns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];

    public static function getActiveUsersCount()
    {
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    public function insert()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::insert();
    }

    public function update()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) $this->end_date = null;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::update();
    }

    private function validate()
    {
        $errors = [];

        if (!$this->name) $errors['name'] = 'Nome é um campo obrigatório.';
        if (!$this->email) {
            $errors['email'] = 'E-mail é um campo obrigatório.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail inválido.';
        }
        if (!$this->start_date) {
            $errors['start_date'] = 'Data de admissão é um campo obrigatório';
        } elseif (!DateTime::createFromFormat('Y-m-d', $this->start_date)) {
            $errors['start_date'] = 'Data de admissão deve seguir o padrão dd/mm/aaaa';
        }
        if ($this->end_date && !DateTime::createFromFormat('Y-m-d', $this->end_date)) {
            $errors['end_date'] = 'Data de desligamento deve seguir o padrão dd/mm/aaaa';
        }
        if ($this->password && $this->confirm_password && $this->password != $this->confirm_password) {
            $errors['password'] = 'As senhas não são iguais';
            $errors['confirm_password'] = 'As senhas não são iguais';
        }

        if (count($errors) > 0) {
            throw new ValidationExceptions($errors);
        }
    }
}
