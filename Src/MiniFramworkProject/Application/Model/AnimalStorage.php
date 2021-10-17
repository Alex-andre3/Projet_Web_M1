<?php
namespace Src\MiniFramworkProject\Application\Model;


use Src\MiniFramworkProject\Application\Model\Animal;

interface AnimalStorage{

	public function read($id);
	public function readAll();
	public function create(Animal $animal);
	}

?>
