<?php 

    ob_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    date_default_timezone_set('America/Toronto');

    $path = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/path.ini');

    // $site_path =  $path['path'];

    $site_path =  '/oop_site';

    define("SITE_ROOT", $_SERVER['HTTP_HOST'] . $site_path);
    define("SITE_ROOT_PRIVATE", $_SERVER['HTTP_HOST'] . $site_path . '/private');
    define("CONFIRMATION", $_SERVER['HTTP_HOST'] . $site_path . '/confirmation.php');
    
    require_once('functions.php');

    // load in class definitions all in one time
    foreach(glob('classes/*.class.php') as $file) {
        require_once($file);
    }

    // autoload only the ones needed
    function my_autoload($class) {

        if (preg_match('/\A\w+\Z/', $class)) {
            include 'classes/' . $class . '.class.php';
        }
    }
    spl_autoload_register('my_autoload');

    $database = new Database($site_path);
    $db = $database->getConnection();

    $site = new Site($db, $site_path);

    $session = new Session;