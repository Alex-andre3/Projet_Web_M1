<?php
namespace Src\MiniFramworkProject\Application\Control;


// require_once("model/AnimalStorage.php");
// require_once("model/AnimalStorageStub.php");
// require_once("control/Controller.php");

use Src\MiniFramworkProject\Framework\Request;
use Src\MiniFramworkProject\Framework\Response;
use Src\MiniFramworkProject\Framework\Views\View;
use Src\MiniFramworkProject\Application\Model\AnimalStorage;
use Src\MiniFramworkProject\Application\Model\AnimalStorageStub;
use Src\MiniFramworkProject\Application\Control\Controller;


class AnimalController extends Controller{

	private $view;
	private $animalsStor;
	//private $animalsTab;


	function __construct(Request $request, Response $response,View $view){
    parent::__construct(  $request,$response);
		$this->view=$view;

    $menu = array(
      "Accueil" => '',
      "medor" => '?o=animal&amp;a=show&amp;id=medor',
      "felix" => '?o=animal&amp;a=show&amp;id=felix',
      "denver" => '?o=animal&amp;a=show&amp;id=denver',
    );
    $this->view->setPart('menu', $menu);
	}

  public function show() {
      // tester les en-têtes HTTP avec Response
      $this->response->addHeader('X-Debugging: show me a poem');
      $id = $this->request->getGetParam('id');
      $animalStorage = new AnimalStorageStub();
      $animal = $animalStorage->read($id);
      if ($animal !== null) {


          $title = "« {$animal->getNom()} », espèce {$animal->getEspece()}";

          $content = "<div>{$animal->getNom()} est un {$animal->getEspece()} de {$animal->getAge()} ans</div>\n";

          $this->view->setPart('title', $title);
          $this->view->setPart('content', $content);

      } else {
          $this->unknownAnimal();
      }
  }

  public function unknownAnimal() {
      $title = "Animal inconnu ou non trouvé";
      $content = "Choisir un animal dans la liste.";
      $this->view->setPart('title', $title);
      $this->view->setPart('content', $content);
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
