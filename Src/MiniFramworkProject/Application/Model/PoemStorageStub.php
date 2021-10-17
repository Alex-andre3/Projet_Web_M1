<?php
namespace Src\MiniFramworkProject\Application\Model;


// require_once("model/Poem.php");
// require_once("model/PoemStorage.php");

use Src\MiniFramworkProject\Application\Model\Poem;
use Src\MiniFramworkProject\Application\Model\PoemStorage;
/* Une classe de démo de l'architecture. Une vraie BD ne contiendrait
 * évidemment pas directement des instances de Poem, il faudrait
 * les construire lors de la lecture en BD. */
class PoemStorageStub implements PoemStorage {

	protected $db;

	/* Construit une instance avec 4 poèmes. */
	public function __construct() {
		$this->db = array(
			"01" => new Poem("Ma bohème", "rimbaud.jpg", "Arthur Rimbaud", "ma_boheme"),
			"02" => new Poem("Correspondances", "baudelaire.jpg", "Charles Baudelaire", "correspondances"),
			"03" => new Poem("Dans les bois", "nerval.jpg", "Gérard de Nerval", "dans_les_bois"),
			"04" => new Poem("Chanson d'automne", "verlaine.jpg", "Paul Verlaine", "chanson_d_automne"),
		);
	}

	public function read($id) {
		if (key_exists($id, $this->db)) {
			return $this->db[$id];
		}
		return null;
	}

	public function readAll() {
		return $this->db;
	}
}

