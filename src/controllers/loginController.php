<?php

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo $user->name;
    } catch (Exception $th) {
        echo 'Falha no login';
    }
}

loadView('login', $_POST);
