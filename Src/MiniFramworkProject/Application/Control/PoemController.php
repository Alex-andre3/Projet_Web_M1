<?php
namespace Src\MiniFramworkProject\Application\Control;



use Src\MiniFramworkProject\Framework\Request;
use Src\MiniFramworkProject\Framework\Response;
use Src\MiniFramworkProject\Framework\AccessManager;
use Src\MiniFramworkProject\Framework\AutenticationManager;
use Src\MiniFramworkProject\Framework\Views\View;
use Src\MiniFramworkProject\Application\Model\PoemStorage;
use Src\MiniFramworkProject\Application\Model\PoemStorageStub;
class PoemController
{
    protected $request;
    protected $response;
    protected $view;
    protected $poemStorage;
    protected $accessmanager;
    protected $authManager;

    public function __construct(Request $request, Response $response, View $view,AccessManager $accessmanager,AutenticationManager $authManager)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->authManager = $authManager;
        $this->accessmanager = $accessmanager;

        $this->accessmanager->setRestrictedId(['01','03']);

        // create menu
        $menu = array(
    			"Poème sympa" => '?o=poem&amp;a=show&amp;id=01',
    			"Autre poème" => '?o=poem&amp;a=show&amp;id=02',
    			"Un poème moins connu" => '?o=poem&amp;a=show&amp;id=03',
    			"Un dernier" => '?o=poem&amp;a=show&amp;id=04',
    		);
        $this->view->setPart('menu', $menu);
    }

    /**
     * exécuter le contrôleur de classe pour effectuer l'action $action
     *
     * @param $action
     */
    public function execute($action)
    {
        $this->$action();
    }

    public function defaultAction()
    {
        return  $this->makeHomePage();
    }

    public function show() {
        // tester les en-têtes HTTP avec Response
        $this->response->addHeader('X-Debugging: show me a poem');
        $id = $this->request->getGetParam('id');
        $poemStorage = new PoemStorageStub();
        $poem = $poemStorage->read($id);
        // echo $_SERVER['REQUEST_URI'];
        
        $this->showLoginForm();

        if ($poem !== null) {
            if(in_array($id,$this->accessmanager->getRestrictedId()) && !$this->accessmanager->getStatut()){
                $title = "";
                $content = "Vous deverez être connecter pour accéder à ce poeme";
            }else{
                /* Le poème existe, on prépare la page */
                $image = "Src/Images/{$poem->getImage()}";
                $title = "« {$poem->getTitle()} », par {$poem->getAuthor()}";
                $content = "<figure>\n<img src=\"$image\" alt=\"{$poem->getAuthor()}\" />\n";
                $content .= "<figcaption>{$poem->getAuthor()}</figcaption>\n</figure>\n";
                $content .= "<div class=\"poem\">{$poem->getText()}</div>\n";
            }

            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content);

        } else {
            $this->unknownPoem();
        }
    }

    public function unknownPoem() {
        $title = "Poème inconnu ou non trouvé";
        $content = "Choisir un poème dans la liste.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    public function makeHomePage() {
        $title = "Bienvenue dans votre galeries des images!";

        $poemStorage = new PoemStorageStub();
        $all_poemes = $poemStorage->readAll();
        $content = "";
        $content .= "
                    <hr class='mt-2 my-5'>
                    <div class='row text-center text-lg-start'>";
        foreach ($all_poemes as $poem) {
        $content .="    <div class='col-lg-3 col-md-4 col-6'>
                            <a href='#' class='d-block mb-4 h-100'>
                                <img class='img-fluid img-thumbnail' src='Src/Images/{$poem->getImage()}' alt=''>
                                <p class='text-center'>{$poem->getTitle()}</p>
                            </a>
                        </div>";
        }
        $content .="</div>";
        $this->showLoginForm();
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    private function showLoginForm(){
        $form_visible = false;
        $this->view->setPart('connexion',$form_visible);
        // var_dump($_POST);
        //voir si qqun est connecté
        if($this->authManager->isConneted() && !key_exists("logout",$_POST)){
            $this->view->setPart('flash', "Vous êtes connecté!");
            $this->view->setPart('logout_btn', "<form action='".$_SERVER['REQUEST_URI']."' method='POST'>
                <input id='prodId' name='logout' type='hidden' value='logout'>
                <input type='submit' id='logout' value='Logout' class='btn btn-danger btn-block ' >
            </form>");
        }else{
                //formulaire de connexion
                $form = '
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" >
                Se connecter
                </button>
                <ul class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="dropdownMenu2">
                    <li class="px-3 py-2">
                            <form action ='.$_SERVER["REQUEST_URI"].' class="form" role="form" method="POST" onSubmit="window.location.reload()">
                                <div class="form-group">
                                    <input id="emailInput" placeholder="Email" class="form-control form-control-sm" type="text" name="id_user" required="" style="width:200px">
                                </div>
                                <div class="form-group">
                                    <input id="passwordInput" placeholder="Mot de passe" class="form-control form-control-sm" type="password" name="psw_user" required="" style="width:200px">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block my-2">Se connecter</button>
                                </div>
                                <div class="form-group text-center">
                                    <small><a href="#" data-toggle="modal" data-target="#modalPassword">Mot de passe oublier?</a></small>
                                </div>
                            </form>
                    </li>
                </ul>
                ';
                if(!key_exists("psw_user",$_POST) || key_exists("logout",$_POST) ){
                    
                    $this->authManager->logout();
                    
                    $form_visible = true;
                    $this->view->setPart('flash', "Connectez-vous");
                    $this->view->setPart('connexion',$form_visible);
                    
                    
                    $this->view->setPart('form_cnx', $form);
                }else{
                    $flash = $this->authManager->login();
                    $this->view->setPart('flash', $flash?"Bonjour, vous êtes bien connecté!":'Vos identifiants sont incorrects !');
                    if(!$flash){
                        $this->view->setPart('form_cnx', $form);

                    }else{
                        //s'il est connecté
                        $this->view->setPart('logout_btn', "
                        <form action='".$_SERVER['REQUEST_URI']."'  method='POST'>
                            <input id='prodId' name='logout' type='hidden' value='logout'>
                            <input type='submit' id='logout' value='Logout' class='btn btn-danger btn-block '>
                        </form>");
                        }
                    }
            }
}

}