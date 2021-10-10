<?php
namespace Project21911226\Framework;


class AccessManager
{

    private $user;
    private $ids;

    public function __construct(Request $request)
    {
        $this->user = $request->getSession('user');
    }

    public function getStatut()
    {
        // var_dump($this->user);
        return $this->user?$this->user['statut']:false;
    }
    
    /**
     *@param [] des ids d'acces restrints
     */
    public function setRestrictedId($ids)
    {
        $this->ids=$ids;
    }

    public function getRestrictedId(){
        return ($this->ids != null )?$this->ids: array();
    }
}