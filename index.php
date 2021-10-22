<?php


function auto_chargement($class){
    
    $keys = explode("\\",$class);
    $filename = "";
    for ($i=0; $i <= count($keys)-2 ; $i++) { 
        $filename .= $keys[$i]."/";
    }
    $filename .= $keys[count($keys)-1];

    //echo $filename;
    include $filename.".php";
    
}

spl_autoload_register('auto_chargement');



// simuler une requête AJAX
//$server['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
use Src\MiniFramworkProject\Framework\Request;
use Src\MiniFramworkProject\Framework\Response;
use Src\MiniFramworkProject\Framework\FrontController;
use Src\MiniFramworkProject\Framework\AutenticationManager;

session_name("MiniFramework");
session_start();

$request = new Request($_GET, $_POST,$_SESSION);
$response = new Response();
$authManager = new AutenticationManager($request);
$router = new FrontController($request, $response);
$router->execute();