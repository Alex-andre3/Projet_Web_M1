<?php
namespace Src\MiniFramworkProject\Framework;



use Src\MiniFramworkProject\Framework\Router;
use Src\MiniFramworkProject\Framework\AutenticationManager;
use Src\MiniFramworkProject\Framework\Views\View;
use Src\MiniFramworkProject\Application\Control\PoemController;
use Src\MiniFramworkProject\Application\Control\AnimalController;

class FrontController
{
    /**
     * request et response
     */
    protected $request;
    protected $response;
    protected $authManager;

    /**
     * constructeur de la classe.
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * méthode pour lancer le contrôleur et exécuter l'action à faire
     */
    public function execute()
    {
        // var_dump($_SESSION['user']);
        // session_destroy();
        $accessMan = new AccessManager($this->request);
        $authManager = new AutenticationManager($this->request);
        

    	$view = new View('Src/MiniFramworkProject/Application/view/templates/template.php');

        // demander au Router la classe et l'action à exécuter
        $router = new Router($this->request);
        $className = $router->getControllerClassName();
        $action = $router->getControllerAction();

        // instancier le controleur de classe et exécuter l'action
        $controller = new $className($this->request, $this->response, $view,$accessMan,$authManager);
        $controller->execute($action);

        /*if ($this->request->isAjaxRequest()) {
        	$content = $view->getPart('content');
        } else {*/
        	$content = $view->render();
        //}

        $this->response->send($content);
    }
}
