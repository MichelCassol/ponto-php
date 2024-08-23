<?php 

require_once(dirname(__FILE__, 2).'/src/config/config.php');
require_once(dirname(__FILE__, 2).'/src/models/User.php');

$user = new User(['name' => 'Michel','email' => 'michel@gmail.com']);

// echo $user->getSelect();

print_r(User::get(['id' => '1'], "name, email"));
print_r(User::get(['name' => 'Chaves'], "id, name, email"));
print_r(User::get());
