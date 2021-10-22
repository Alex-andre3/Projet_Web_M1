<?php
namespace Src\MiniFramworkProject\Application\Model;
class Picture{

    protected $title;
	protected $image;

    public function __construct($title, $image) {
		$this->title = $title;
		$this->image = $image;
	}

    public function getTitle() {
		return $this->title;
	}

	public function getImage() {
		return $this->image;
	}
}