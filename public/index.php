<?php 

require_once(dirname(__FILE__, 2).'/src/config/config.php');
require_once(dirname(__FILE__, 2).'/src/models/User.php');

$user = new User(['name' => 'Michel','email' => 'michel@gmail.com']);

// echo $user->getSelect();

echo User::getSelect(['name' => 'Chaves','email' => 'chaves@cod3r.com.br'], "name, email");
