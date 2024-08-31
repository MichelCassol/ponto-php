<?php
loadModel('Login');
$exception = null;

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo $user->name;
    } catch (AppExceptions $th) {
		$exception = $th;
    }
}

loadView('login', $_POST + ['exception' => $exception]);
