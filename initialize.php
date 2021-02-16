<?php 

    ob_start(); // turn on output buffering

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // $db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini');

    // echo '<pre>';
    // print_r($db);

    define("SITE_ROOT", $_SERVER['HTTP_HOST'] . '/oop_site');
    define("SITE_ROOT_PRIVATE", $_SERVER['HTTP_HOST'] . '/oop_site/private');

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

    $database = new Database();
    $db = $database->getConnection();

    // include_once 'classes/database.class.php';

    $site = new Site($db);

    $session = new Session;