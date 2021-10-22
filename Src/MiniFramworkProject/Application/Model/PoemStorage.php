<?php
namespace Src\MiniFramworkProject\Application\Model;


/* Interface représentant un système de stockage des poèmes. */
interface PoemStorage {
	/* Renvoie l'instance de Poem correspondant à l'identifiant donné,
	 * ou null s'il n'y en a pas. */
	public function read($id);

	/* Renvoie un tableau associatif id=>poème avec tous les poèmes de la base. */
	public function readAll();
}

?>
