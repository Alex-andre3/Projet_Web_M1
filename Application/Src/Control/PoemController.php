<?php
namespace Project21911226\Application\Src\Control;


// require_once("model/PoemStorage.php");
// require_once("model/PoemStorageStub.php");
use Project21911226\Framework\Request;
use Project21911226\Framework\Response;
use Project21911226\Framework\AccessManager;
use Project21911226\Framework\AutenticationManager;
use Project21911226\Framework\Views\View;
use Project21911226\Application\Src\Model\PoemStorage;
use Project21911226\Application\Src\Model\PoemStorageStub;
class PoemController
{
    protected $request;
    protected $response;
    protected $view;
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
    			"Accueil" => '?',
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
                $image = "Application/images/{$poem->getImage()}";
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
        $title = "Bienvenue !";
        $content = "Un site sur des poèmes.";
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
                <input type='submit' id='logout' value='Logout' >
            </form>");
        }else{
                //formulaire de connexion
                $form = "
                <form action='".$_SERVER['REQUEST_URI']."'  method='POST'>
                    <h1>Connexion</h1>
                    
                    <label><b>Nom d'utilisateur</b></label>
                    <input type='text' placeholder='Entrer le nom d'utilisateur' name='id_user' required>

                    <label><b>Mot de passe</b></label>
                    <input type='password' placeholder='Entrer le mot de passe' name='psw_user' required>

                    <input type='submit' id='submit' value='LOGIN' >
                </form>
                " ;
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
                            <input type='submit' id='logout' value='Logout' >
                        </form>");
                        }
                    }
            }
}

}