<?php
namespace Src\MiniFramworkProject\Framework;


/**
 * Ajouter un attribut $server qui contient $_SERVER
 */
class Request
{
    private $get;
    private $post;
    private $session;

    public function __construct($get, $post,$session)
    {
        $this->get = $get;
        $this->post = $post;
        $this->session = $session;
    }

    

    /**
     * @param $key la clé à chercher dans GET
     * @param $default la valeur à renvoyer si $key n'existe pas
     * @return null
     */
    public function getGetParam($key, $default = null)
    {
        if (!isset($this->get[$key])) {
            return $default;
        }
        return $this->get[$key];
    }

    /**
     * @param $key la clé à chercher dans POST
     * @param $default la valeur à renvoyer si $key n'existe pas
     * @return null
     */
    public function getPostParam($key, $default)
    {
        return key_exists($key,$this->post)?$this->post[$key]:$default;
        // if (!isset($this->post[$key])) {
        //     return $default;
        // }
        // return $this->post[$key];
    }

    /**
     * obtenir tous les paramètres POST
     * @return array
     */
    public function getAllPostParams()
    {
        return $this->post;
    }

    public function getSession($key)
    {
        return key_exists($key,$this->session)?$this->session[$key]:array();
    }
    public function setSession($key,$value)
    {
        $this->session[$key]=$value;
    }


    public function getServer($key)
    {
        return key_exists($key,$_SERVER)?$_SERVER[$key]:null;
    }
    public function __destruct()
    {
        $_SESSION = $this->session;
    }
}
