<?php
namespace Project21911226\Framework;


// require_once('Request.php');
use Project21911226\Framework\Request;
use Project21911226\Framework\conf;

class Router
{
    protected $controllerClassName;
    protected $controllerAction;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->parseRequest();
    }


    protected function parseRequest()
    {
      // un nom de package est-il spécifié dans l'URL ?
        $package = $this->request->getGetParam('o');

        // Regarder quel contrôleur instancier
        switch ($package) {
            case 'poem':
                $this->controllerClassName = 'Project21911226\Application\Src\Control\PoemController';
                break;
            case 'animal':
                $this->controllerClassName = 'Project21911226\Application\Src\Control\AnimalController';
                break;
            default:
                // idem ici, on peut imaginer un package à utiliser par défaut
                // j'utilise ArticleController pour l'instant car c'est le seul existant
                $this->controllerClassName = 'Project21911226\Application\Src\Control\PoemController';
        }

        // tester si la classe à instancier existe bien. Si non lancer une Exception.
        if (!class_exists($this->controllerClassName)) {
            // throw new Exception("Classe {$this->controllerClassName} non existante");
        }

        // regarder si une action est demandée dans l'URL
        // si le paramètre 'a' n'existe pas alors l'action sera 'defaultAction'
        $this->controllerAction = $this->request->getGetParam('a', 'defaultAction');
	}

    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }

    public function getControllerAction()
    {
        return $this->controllerAction;
    }
}
