<?php
namespace Src\MiniFramworkProject\Application\Model;




use Src\MiniFramworkProject\Application\Model\Poem;
use Src\MiniFramworkProject\Application\Model\PoemStorage;

class PoemStorageStub implements PoemStorage {

	protected $db;

	public function __construct() {
		$this->db = array(
			"01" => new Poem("Ma bohème", "rimbaud.jpg", "Arthur Rimbaud", "ma_boheme"),
			"02" => new Poem("Correspondances", "baudelaire.jpg", "Charles Baudelaire", "correspondances"),
			"03" => new Poem("Dans les bois", "nerval.jpg", "Gérard de Nerval", "dans_les_bois"),
			"04" => new Poem("Chanson d'automne", "verlaine.jpg", "Paul Verlaine", "chanson_d_automne"),
		);
	}

	public function read($id) {
		// if (key_exists($id, $this->db)) {
		// 	return $this->db[$id];
		// }
		// return null;

		return key_exists($id, $this->db)?$this->db[$id]:null;
	}

	public function readAll() {
		return $this->db;
	}
}

