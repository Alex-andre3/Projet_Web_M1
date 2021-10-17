<?php
namespace Src\MiniFramworkProject\Framework;


use Src\MiniFramworkProject\Framework\Request;

class AutenticationManager
{
    private $request;
    private $users = array(
        'jml' => array(
            'id' => 12,
            'nom' => 'Lecarpentier',
            'prenom' => 'Jean-Marc',
            'mdp' => 'toto',
            'statut' => 'admin'
        ),
        'alex' => array(
            'id' => 5,
            'nom' => 'Niveau',
            'prenom' => 'Alexandre',
            'mdp' => 'toto',
            'statut' => 'admin'
        ),
        'julia' => array(
            'id' => 12,
            'nom' => 'Dupont',
            'prenom' => 'Julia',
            'mdp' => 'toto',
            'statut' => 'redacteur'
        )
    );

    public function __construct(Request $request){
        $this->request = $request;
    }


    public function isConneted(){
        if (!key_exists("id", $this->request->getSession("user")) ||
            !key_exists("mdp", $this->request->getSession("user"))) {
                //session_start();
                return false;
        } 
        return true;
        /*else {
            $_SESSION['user'] = $this->request->getSession();
            return true;
        }*/
    }

    public function login(){
        $id =$this->request->getPostParam('id_user',null);
        $password = $this->request->getPostParam('psw_user',null);
        foreach ($this->users as $key => $user) {
            if($key === $id && $user['mdp'] === $password ){
                //$_SESSION['user'] = $user;
                $this->request->setSession('user',$user);
                // var_dump($this->request->getSession('user'));
                //Flash Success
                return true;
            }
        }
        //page de login avec Flash Erreur
        return false;
    }

    public function logout(){
        session_destroy();
    }

    
}