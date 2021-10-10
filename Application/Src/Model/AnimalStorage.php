<?php
namespace Project21911226\Application\Src\Model;


use Project21911226\Application\Src\Model\Animal;

interface AnimalStorage{

	public function read($id);
	public function readAll();
	public function create(Animal $animal);
	}

?>
