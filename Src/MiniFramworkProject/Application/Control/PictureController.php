<?php
namespace Src\MiniFramworkProject\Application\Control;


use Src\MiniFramworkProject\Framework\Request;
use Src\MiniFramworkProject\Framework\Response;
use Src\MiniFramworkProject\Framework\AccessManager;
use Src\MiniFramworkProject\Framework\AutenticationManager;
use Src\MiniFramworkProject\Framework\Views\View;
use Src\MiniFramworkProject\Application\Model\PictureStorage;
use Src\MiniFramworkProject\Application\Model\PictureStorageStub;

require_once('vendor/autoload.php');
class PictureController
{
    protected $request;
    protected $response;
    protected $view;
    protected $menu;// à la place de $view
    protected $accessmanager;
    protected $authManager;
    protected $pictureStorage;
    protected $twig; 

    public function __construct(Request $request, Response $response, View $view,AccessManager $accessmanager,AutenticationManager $authManager)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
        $this->authManager = $authManager;
        $this->accessmanager = $accessmanager;
        $this->accessmanager->setRestrictedId(['01','03','05','07','09','11']); //problème d'actualisation lors de la cnx

        $directories = array('Src/MiniFramworkProject/Application/view/templates'
                            ,'Src/MiniFramworkProject/Application/view/templates/picture');
        $loader = new \Twig\Loader\FilesystemLoader($directories);
        $this->twig = new \Twig\Environment($loader);
        // create menu
        $this->menu = array(
    			"A propos" => '?o=poem&amp;a=show&amp;id=04',
    		);
        $this->view->setPart('menu', $this->menu);
        $this->pictureStorage = new PictureStorageStub();
    }

    public function execute($action)
    {
        $this->$action();
    }

    public function defaultAction()
    {
        return  $this->makeHomePage();
    }

    

    //page des détails d'une image
    public function show() {
        // tester les en-têtes HTTP avec Response
        $this->response->addHeader('X-Debugging: show me a picture');
        //envoyer l'entête

        $id = $this->request->getGetParam('id');
        // $pictureStorage = new PictureStorageStub();
        $picture = $this->pictureStorage->read($id);
        // echo $_SERVER['REQUEST_URI'];
       

        $this->showLoginForm();

        if ($picture !== null) {
            if(in_array($id,$this->accessmanager->getRestrictedId()) && !$this->accessmanager->getStatut()){
                $title = "Accès restreint";
                $content = "Vous deverez être connecter pour accéder à cette image";
                //acces denied page
                echo $this->twig->render('accessdenied.html.twig',[
                    'title'=> "Accès restreint"
                   ,'content' => "Vous deverez être connecter pour accéder à cette image"
                   ,'menu' => $this->menu
                   ,'url' => $_SERVER["REQUEST_URI"]
                   ,'connexion' => $this->authManager->isConneted()
                ]);
            }else{
                $image = "Src/Images/{$picture->getName()}";
                $title = "« {$picture->getTitle()} »";

                if((isset($picture->getGps_data()[2])) && (!is_null($picture->getGps_data()[2]))){
                    $adresse = $picture->getGps_data()[2]; // on recupere l'adresseeeee entière latitude + longetude
                    //var_dump($adresse);
                    if(isset($adresse)){
                    $adresse1 = str_replace('deg','°',$adresse);
                    $adresse2 = str_replace(' ','', $adresse1);
                    $separe_lat_long = explode(',',$adresse2);
                    $lat = $this->convertDMStoDecimalDegrees($separe_lat_long[0]);
                    $long = $this->convertDMStoDecimalDegrees($separe_lat_long[1]);
                    }
                }
                /* 
                 !! DONE !!
                 pour la géolocalisation 
                 geo dans https://schema.org/Place
                 
                 autre itemprop dans Article : 
                    copyrightHolder
                    creator : createur de l'image 
                    description
                    url : pour la source
                    Pour les mot-clés(
                    type -> BlogPosting | prop -> itemprop="keywords" | rel -> tag (voir : https://stackoverflow.com/questions/8039651/how-do-you-format-keywords-in-microdata-for-a-creativework)
                        )
                */
                
                /*
                $key_words = '';
                foreach ($picture->getKeywords_tags() as $key) {
                    $key_words .="<li itemprop='keywords'>{$key}</li>\n";
                }
                $content = "
                <div itemscope itemtype='https://schema.org/Article' class='row jumbotron'>
                    <div class='row w-100' >
                        <div class='col-lg-6 col-12 '>
                            <figure  itemprop='image' itemscope itemtype='https://schema.org/ImageObject'>
                                <img itemprop='image' src=\"$image\" alt=\"{$picture->getTitle()}\" style='max-width:100%'/>
                                <figcaption itemprop='name' class='text-center my-3'>{$picture->getTitle()}</figcaption>
                            </figure>
                            <div class='text-center my-3'>
                            <a href='?o=picture&amp;a=buy&amp;id=$id' class='btn btn-outline-primary' role='button' >Acheter | {$picture->getAmount()} €</a>
                            </div>
                        </div>
                        
                        <div  class='col-lg-6 col-12'>
                            <div itemprop='articleBody' class='row'>
                                {$picture->getDescription()}
                            </div>
                            <hr>
                            <div class='row'>
                                <div itemprop='author' itemscope itemtype='https://schema.org/Person'  class='col-lg-4 col-12'>
                                    <p itemprop='name'> author(s) : {$picture->getCreator()}</p>
                                </div>
                                <div class='col-lg-4 col-12'>
                                    <p>created at : {$picture->getCreated_date_time()}</p>
                                </div>
                                <div class='col-lg-4 col-12'>
                                    <p>last update : {$picture->getLast_modification()}</p>
                                </div>
                            </div>
                            <hr>
                            <div class='row'>
                                <div itemprop='countryOfOrigin' itemscope itemtype='https://schema.org/Country' class='col-lg-4 col-12'>
                                    <p itemprop='name'> country : {$picture->getCountry()}</p>
                                </div>
                                <div itemscope itemtype='https://schema.org/State'  class='col-lg-4 col-12'>
                                    <p itemprop='name'>state : {$picture->getState()}</p>
                                </div>
                                <div itemscope itemtype='https://schema.org/City' class='col-lg-4 col-12'>
                                    <p itemprop='name'>city : {$picture->getCity()}</p>
                                </div>
                            </div>
                            <hr>
                            <div itemscope itemtype='http://schema.org/CreativeWork' class='row'>
                                Key words :
                                <ul>
                                    {$key_words}
                                </ul>
                            </div>
                        </div>                         
                    </div>
                    <div class='row' style='width:100%'>
                                <div itemprop='copyrightHolder' itemscope itemtype='https://schema.org/Organization'  class='col-lg-4 col-12' >
                                    <p itemprop='name'>{$picture->getCopy_rights()}</p>
                                </div>
                                <div class='col-lg-4 col-12'>
                                    <a href='{$picture->getUsage_terms()}'>Usage terms</a>
                                </div>
                                <div class='col-lg-4 col-12'>
                                    Source-link : <a href='{$picture->getSource_link()}' w-100>{$picture->getSource_link()}</a>
                                </div>
                            </div>
                </div>
                <div itemprop='contentLocation' itemscope itemtype='https://schema.org/Place' id='map'>
                </div>
                <style>
                #map {
                    height: 500px;
                    width: 100%;
                }
                    html, body {
                        height: 100%;
                        margin: 0;
                        padding: 0;
                      }
                    </style>

                <div id='map'></div>

                <script>
                
                let map;
                function initMap() {
                    console.log('bonsoir paris');
                    const myLatLng = { lat: $lat, lng: $long };
                    map = new google.maps.Map(document.getElementById('map'), {
                      center: myLatLng,
                      zoom: 12,
                    });
                
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: 'Hello World!',
                  });
                } 
                
                </script>
                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCAu1zg8FhDFL9LxaEuh2sxdq93jnO3GiU&callback=initMap&v=weekly'
                async>
                </script>
                ";
                */
                $script_geo = "
                <script>
                
                let map;
                function initMap() {
                    console.log('bonsoir paris');
                    const myLatLng = { lat: $lat, lng: $long };
                    map = new google.maps.Map(document.getElementById('map'), {
                      center: myLatLng,
                      zoom: 12,
                    });
                
                new google.maps.Marker({
                    position: myLatLng,
                    map,
                    title: 'Hello World!',
                  });
                } 
                
                </script>
                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCAu1zg8FhDFL9LxaEuh2sxdq93jnO3GiU&callback=initMap&v=weekly'
                async>
                </script>
                ";
                echo $this->twig->render('details.html.twig',[
                    'title'=> $title
                //    ,'content' => $content
                   ,'picture' => [$id,$picture]
                   ,'script_geo' => $script_geo
                //    ,'restricted_pics' => $this->accessmanager->getRestrictedId()
                   ,'menu' => $this->menu
                   ,'url' => $_SERVER["REQUEST_URI"]
                   ,'connexion' => $this->authManager->isConneted()
                ]);
            }
        }else {
            // $this->unknownPicture();
            echo $this->twig->render('pageNotFound.html.twig',[
               'menu' => $this->menu
               ,'url' => $_SERVER["REQUEST_URI"]
               ,'connexion' => $this->authManager->isConneted()
            ]);
        }
    }

    public function unknownPicture() {
        $title = "Not found";
        $content = "Sorry, unknown picture or not found ! Choose an other image.";
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);
    }

    public function makeHomePage() {
        $title = "Wellcome to this awesome gallery, click on the pictures below  to discover the story behind it :) ";

        $all_pictures = $this->pictureStorage->readAll();//recuperation des objets de la 'BD'
        
        $this->showLoginForm();

        //FrontController : il ne faut pas oublier d'envoyer les entetes $this->response->sendHeaders($content) 
        echo $this->twig->render('home.html.twig',[
             'title'=> $title
            ,'all_pictures' => $all_pictures
            ,'menu' => $this->menu
            ,'url' => $_SERVER["REQUEST_URI"]
            ,'connexion' => $this->authManager->isConneted()
            // ,'flash' => ['success','test message']
    ]);

    }

    private function convertDMStoDecimalDegrees($convert){

        $separe1 = explode('°',$convert);
        $d = $separe1[0];

        $separe2 = explode('\'',$separe1[1]);
        $min = $separe2[0];

        $separe3 = explode("\"", $separe2[1]);
        $sec = $separe3[0];

        $pointCardinal = $separe3[1];

        $res = floatval($d + ($min/60) + ($sec/3600));
  
        switch ($pointCardinal) {
            case 'S':
                $res *= -1;
                break;
            case 'W':
                $res *= -1;
                break;
            default:
                $res *= 1;
                break;
        }
        return $res; 


    }

    public function buy(){

        $this->response->addHeader('X-Debugging: show me a page to buy picture');
        $this->showLoginForm();

        $id = $this->request->getGetParam('id');
        $picture = $this->pictureStorage->read($id);

        if($picture != null){
            $amount = $picture->getAmount();
            $test_retour = "o=picture&amp;a=manualReturnPurchase&amp;id=$id";
            $test_retour1= "?a=manualReturnPurchase";
            $test_annul = "?a=cancellingReturnPurchase";
            $test_auto_return = "?a=autoReturnPurchase";
            $image = "Src/Images/{$picture->getName()}";
        

            $content = "Le montant de la transaction est de <b>$amount euros</b> <br>";
            $content .= '<form action="" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Rentrez votre adresse mail pour effectuer l\'achat</label>
              <input type="email" class="form-control" name="emailToPurchase" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
              <small id="emailHelp" class="form-text text-muted">We\'ll never share your email with anyone else.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          
          ';
          $content .= "<img itemprop='image' src=\"$image\" alt=\"{$picture->getTitle()}\" style='max-width:100%'/>";

          if((isset($_POST['emailToPurchase']))&& (!empty($_POST['emailToPurchase']))){
            $customerEmail = $_POST['emailToPurchase'];
            $content .= "<br>L'adresse mail qui sera utilisé est : $customerEmail";
            $all_keys = array(

                'merchant_id' => "014295303911111",
                "merchant_country" => "fr",
                "currency_code" => 978,
                "pathfile" => "Src/Sherlocks/Sherlocks/param_demo/pathfile", 
                "transaction_id" => "",
                "normal_return_url" => "https://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'].$test_retour1,
                "cancel_return_url" => "https://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'].$test_annul,
                "automatic_response_url" => "https://".$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'].$test_auto_return,
                "language" => "fr",
                "payment_means" => "CB,2,VISA,2,MASTERCARD,2",
                "header_flag" => "",
                "capture_day" => "",
                "capture_mode" => "",
                "background_id" => "", 
                "bgcolor" => "", 
                "block_align" => "center",
                "block_order" => "",
                "textcolor" => "", 
                "textfont" => "", 
                "templatefile" => "",
                "logo_id" => "", 
                "receipt_complement" => "", 
                "caddie" => "", 
                "customer_id" => 33,
                "customer_email" => "", 
                "customer_ip_address" => "", 
                "data" => "", 
                "return_context" => "",
                "target" => "", 
                "order_id" => 44,
                "amount" => $amount*100
            ); 
    
            $request = "";
            foreach ($all_keys as $key => $value) {
            $request .= $key . "=" . $value . " ";
                }    
        
            $result = exec("Src/Sherlocks/Sherlocks/bin/request" ." " . $request);
            //var_dump($result);
            $test = explode("!", $result)[3];
            $content .= $test;
          }         
        }
        $title = "Acheter cette image";

        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);

    }

    public function manualReturnPurchase(){

        $this->response->addHeader('X-Debugging: show me a page to buy picture');
        $this->showLoginForm();

        $message = $_POST['DATA'];// il faut accèder au post par la classe Response
        $pathfile = "Src/Sherlocks/Sherlocks/param_demo/pathfile";
        $response = exec("Src/Sherlocks/Sherlocks/bin/response" . " ". "message"."=".$message . " ". "pathfile"."=".$pathfile );
        $response2 = explode("!", $response);

        $amount = $response2[5]/100;
        $date = $response2[10];


        $contentLog = "\n ############################################################## \n";
        $contentLog .= "Achat de " . $amount . "$\n";
        $contentLog .=  "Paiement effectué le " . $date; 
        $contentLog .= "\n";

        $fichier = fopen('Src/logs.txt', 'c+b');
        fwrite($fichier, $contentLog);

        $title = "Merci pour votre achat !";
        $content = "Le montant de la transaction réalisée est de $amount euros <br>";
        $content .= "Transaction effectuée le $date ";
        
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);


    }

    public function autoReturnPurchase(){

        $this->response->addHeader('X-Debugging: show me a page to buy picture');
        $this->showLoginForm();

        $title = "retour auto mec";
        $content = "Le montant de la transaction est de 14 (pour l'instant)";
        
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);

    }
    
    public function cancellingReturnPurchase(){

        $this->response->addHeader('X-Debugging: show me a page to buy picture');
        $this->showLoginForm();

        $title = "Désolé la transaction n'a pas pu aboutir.";
        $content = "Veuillez vérifier les informations fournies pour effectuer le paiement";
        
        $this->view->setPart('title', $title);
        $this->view->setPart('content', $content);

    }

    private function showLoginForm(){
        $form_visible = false;
        $this->view->setPart('connexion',$form_visible);
        // var_dump($_POST);
        //voir si qqun est connecté
        if($this->authManager->isConneted() && !key_exists("logout",$_POST)){
            $this->view->setPart('flash', "Vous êtes connecté!");//flash
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
                        $logout_btn = "<form action='".$_SERVER['REQUEST_URI']."'  method='POST'>
                                            <input id='prodId' name='logout' type='hidden' value='logout'>
                                            <input type='submit' id='logout' value='Logout' class='btn btn-danger btn-block '>
                                        </form>";
                        $this->view->setPart('logout_btn',$logout_btn);
                        }
                    }
            }
    }
}