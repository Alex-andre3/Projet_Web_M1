<?php
namespace Src\MiniFramworkProject\Application\Model;


/* Représente un poème. */
class Poem {

	protected $title;
	protected $image;
	protected $author;
	protected $text;

	public function __construct($title, $image, $author, $textFile) {
		$this->title = $title;
		$this->image = $image;
		$this->author = $author;
		$this->text = file_get_contents("texts/{$textFile}.frg.html", true);
	}

	public function getTitle() {
		return $this->title;
	}

	public function getImage() {
		return $this->image;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function getText() {
		return $this->text;
	}

}

?>
