<?php
loadModel('Login');

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo $user->name;
    } catch (AppExceptions $th) {
        echo $th->getMessage();
    }
}

loadView('login', $_POST);
