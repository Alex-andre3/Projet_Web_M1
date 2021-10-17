<?php
namespace Src\MiniFramworkProject\Application\Model;


use Src\MiniFramworkProject\Application\Model\Animal;
use Src\MiniFramworkProject\Application\Model\AnimalStorage;

// require_once ("AnimalStorage.php");
// require_once("Animal.php");

class AnimalStorageStub implements AnimalStorage{

	private $tabAnimal;

	function __construct(){

	    $this->tabAnimal=array(
			'medor' => new Animal("Médor", "chien",5),
			'felix' => new Animal("Félix", "chat",2),
			'denver' => new Animal("Denver", "dinosaure",15),
		);
	}


	public function read($id){
		if(key_exists($id,$this->tabAnimal)){
		foreach($this->tabAnimal as $key => $value){
			if($id === $key)
			return $value;
     		}
		}
		else return null;
		}


	public function readAll(){
		foreach($this->tabAnimal as $id => $animal){
			$Allanimal[]=array($id => $animal);
		}
		return $Allanimal;
	}

	public function create(Animal $a){
		}
}
?>
