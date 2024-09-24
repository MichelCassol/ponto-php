<?php 
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

// Constantes gerais
define('DAILY_TIME', 60 * 60 * 8);

// Pastas
define('MODEL_PATH', realpath(dirname(__FILE__, 2) . '/models'));
define('VIEW_PATH', realpath(dirname(__FILE__, 2) . '/views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__, 2) . '/views/templates'));
define('CONTROLLER_PATH', realpath(dirname(__file__, 2) . '/controllers'));
define('EXCEPTION_PATH', realpath(dirname(__file__, 2) . '/exceptions'));

// Arquivos
require_once(realpath(dirname(__FILE__) . '/database.php'));
require_once(realpath(dirname(__FILE__) . '/loader.php'));
require_once(realpath(dirname(__FILE__) . '/session.php'));
require_once(realpath(dirname(__FILE__) . '/date_utils.php'));
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(MODEL_PATH . '/User.php'));
require_once(realpath(EXCEPTION_PATH . '/AppExceptions.php'));
require_once(realpath(EXCEPTION_PATH . '/ValidationExceptions.php'));
