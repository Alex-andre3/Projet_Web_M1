<?php
namespace Src\MiniFramworkProject\Application\Control;


use Src\MiniFramworkProject\Framework\Request;
use Src\MiniFramworkProject\Framework\Response;
use Src\MiniFramworkProject\Framework\AccessManager;
use Src\MiniFramworkProject\Framework\AutenticationManager;
use Src\MiniFramworkProject\Framework\Views\View;
use Src\MiniFramworkProject\Application\Model\PictureStorage;
use Src\MiniFramworkProject\Application\Model\PictureStorageStub;
class MenuController
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

        $this->accessmanager->setRestrictedId(['apropos','03']);

        // create menu
        $menu = array(
    			//"Image sympa" => '?o=poem&amp;a=show&amp;id=01',
                "Uploader une image" => '?o=menu&amp;a=show&amp;stp=upload',
                "Modifier/Supprimer une image" => '?o=menu&amp;a=show&amp;stp=modif',
                "A propos" => '?o=menu&amp;a=show&amp;stp=apropos'
    		);
        $this->view->setPart('menu', $menu);
    }

    public function execute($action)
    {
        $this->$action();
    }

    public function defaultAction()
    {
        return  $this->makeHomePage();
    }

    public function show() {
        //echo "salut";
        // tester les en-têtes HTTP avec Response
        $this->response->addHeader('X-Debugging: show me a picture');
        $id = $this->request->getGetParam('stp');
        //$pictureStorage = new PictureStorageStub();
        //$picture = $pictureStorage->read($id);
        // echo $_SERVER['REQUEST_URI'];
        
        $this->showLoginForm();



      //  if ($picture !== null) {
        //    if(in_array($id,$this->accessmanager->getRestrictedId()) && !$this->accessmanager->getStatut()){
          //      $title = "";
           //     $content = "Vous deverez être connecter pour accéder à cette image";
           // }else{
                /* Le poème existe, on prépare la page */
               /* $image = "Src/Images/{$picture->getImage()}";
                $title = "« {$picture->getTitle()} »";
                $content = "<figure>\n<img src=\"$image\" alt=\"{$picture->getTitle()}\" />\n";
            }

            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content);

        } else {
            $this->unknownMenu();
        }*/
       // echo " $id";
        if($id =="apropos"){
            
            if($id== in_array($id,$this->accessmanager->getRestrictedId()) && !$this->accessmanager->getStatut()){
                      $title = "";
                      $content = "Vous devez être connecté pour accéder à cette image";
            }
            else{
                $title = "A propos";
                $content = "A propos de Ilyas et Alexandre";
            }
                $this->view->setPart('title', $title);
                $this->view->setPart('content', $content);
        }
        elseif($id =="upload"){
            
            if($id== in_array($id,$this->accessmanager->getRestrictedId()) && !$this->accessmanager->getStatut()){
                        $title = "";
                        $content = "Vous deverez être connecter pour accéder à cette image";
            }
            else{
                $title = "Page pour l'upload";
                $content = '<div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choisir une image à uploader</label>
              </div>';

              $content .= "Faire une requête AJAX pour ça donc il faut changer";
              
            }   
            $this->view->setPart('title', $title);
            $this->view->setPart('content', $content); 
        }
   
        else{
            $this->unknownMenu();
        }
    
    }


    public function unknownMenu() {
        $title = "Ou veux-tu aller comme ça ?";
        $content = "Choisis un bon paramètre ou reviens en arrière.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    public function makeHomePage() {
        $title = "Bienvenue dans votre galeries des images!";

        $pictureStorage = new PictureStorageStub();
        $all_pictures = $pictureStorage->readAll();
        $content = "";
        $content .= "
                    <hr class='mt-2 my-5'>
                    <div class='row text-center text-lg-start'>";

        $compteur = 1;            
        foreach ($all_pictures as $pic) {
        $content .="    <div class='col-lg-3 col-md-4 col-6'>
                            <a href='?o=pict&amp;a=show&amp;id=$compteur' class='d-block mb-4 h-100'>
                                <img class='img-fluid img-thumbnail' src='Src/Images/{$pic->getImage()}' alt=''>
                                <p class='text-center'>{$pic->getTitle()}</p>
                            </a>
                        </div>";
                        $compteur++;
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
                            <form action ='.$_SERVER["REQUEST_URI"].' class="form" role="form" method="POST">
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