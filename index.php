<?php

// set_include_path("./tp1");

// require_once("control/FrontController.php");
// require_once('Framework/Request.php');
// require_once('Response.php');

function auto_chargement($class){
    //  $filename = str_replace('\\', '/', $class).'.php';
    // var_dump(explode("\\",$class));
    $keys = explode("\\",$class);
    $filename = "";
    for ($i=1; $i <= count($keys)-2 ; $i++) { 
        $filename .= $keys[$i]."/";
    }
    $filename .= $keys[count($keys)-1];

    // echo $filename."<br>";
    include $filename.".php";
    //  if (file_exists($filename)){
    //      echo "XXXX";
    //     include $filename.".php";
    //  }
}

spl_autoload_register('auto_chargement');

/* Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de lancer le FrontController.
 *
 */


// simuler une requête AJAX
//$server['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
use Project21911226\Framework\Request;
use Project21911226\Framework\Response;
use Project21911226\Framework\FrontController;
use Project21911226\Framework\AutenticationManager;

session_name("littleFramework");
session_start();

$request = new Request($_GET, $_POST,$_SESSION);
$response = new Response();
$authManager = new AutenticationManager($request);
$router = new FrontController($request, $response);
$router->execute();