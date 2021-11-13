<?php
namespace Src\MiniFramworkProject\Framework;
/**
 * Class Response
 *
 * embryon de classe pour gérer la réponse HTTP
 */
require_once('vendor/autoload.php');
class Response
{
    /**
     * @var array
     * liste des en-têtes HTTP
     */
	private $headers = array();

    /**
     * @param $headerValue
     * ajouter un en-tête à la liste
     * par exemple pour changer le Content-Type
     */
	public function addHeader($headerValue) {
		$this->headers[] = $headerValue;
	}

    /**
     * envoie tous les headers au client
     * @todo utilise la liste dans l'ordre où les en-têtes ont été ajoutés ce qui peut devenir incohérent
     */
	public function sendHeaders() {
		foreach ($this->headers as $header) {
			header($header);
		}
	}

    /**
     * @param $content
     * envoi de la réponse au client
     */
	public function send($content)
	{
		$this->sendHeaders();
        
        $loader = new \Twig\Loader\FilesystemLoader('Src/MiniFramworkProject/Application/view/templates');
        $twig = new \Twig\Environment($loader);
        // var_dump($content);
        // echo $content;
        echo $twig->render('base.html.twig',['title'=> $content['title']
        ,'content'=>$content['content']
        ,'menu' => $content['menu']
        ,'form_cnx' => $content['form_cnx']
        ,'connexion' => $content['connexion']
        ,'logout_btn' => key_exists('logout_btn',$content) ? $content['logout_btn'] : null
    
    ]);
	}
}
