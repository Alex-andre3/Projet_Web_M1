<?php
namespace Project21911226\Application\Src\Control;

use Project21911226\Framework\Request;
use Project21911226\Framework\Response;
class Controller{
  protected $request;
  protected $response;

  public function __construct(Request $request, Response $response){
    $this->request = $request;
    $this->response = $response;
  }


  public function execute($action)
  {
      $this->$action();
  }
  public function defaultAction()
  {
      return  $this->makeHomePage();
  }

  public function makeHomePage() {
      $title = "Bienvenue !";
      $content = "Un site sur les animaux.";
      $this->view->setPart('title', $title);
      $this->view->setPart('content', $content);
  }
}
