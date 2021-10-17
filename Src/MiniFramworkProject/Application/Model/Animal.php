<?php
namespace Src\MiniFramworkProject\Application\Model;


class Animal{

	private $nom;
	private $age;
	private $espece;

	function __construct($nom,$espece,$age){
		$this->nom=$nom;
		$this->age=$age;
		$this->espece=$espece;
	}
	/* Getter */
	public function getNom(){
		return $this->nom;
	}
	public function getAge(){
		return $this->age;
	}
	public function getEspece(){
		return $this->espece;
	}


}
?>
