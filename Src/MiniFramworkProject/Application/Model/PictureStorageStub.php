<?php
namespace Src\MiniFramworkProject\Application\Model;


use Src\MiniFramworkProject\Application\Model\Picture;
use Src\MiniFramworkProject\Application\Model\PictureStorage;
class PictureStorageStub implements PictureStorage{
    protected $db;

	public function __construct() {
		$this->db = array(
			"01" => new Picture("default_title1", "photo1.jpg"),
			"02" => new Picture("default_title2", "photo2.jpg"),
			"03" => new Picture("default_title3", "photo3.jpg"),
			"04" => new Picture("default_title4", "photo4.jpg"),
			"05" => new Picture("default_title5", "photo5.jpg"),
			"06" => new Picture("default_title6", "photo6.jpg"),
			"07" => new Picture("default_title7", "photo7.jpg"),
			"08" => new Picture("default_title8", "photo8.jpg"),
			"09" => new Picture("default_title9", "photo9.jpg"),
			"10" => new Picture("default_title10", "photo10.jpg"),
			"11" => new Picture("default_title11", "photo11.jpg"),
			"12" => new Picture("default_title12", "photo12.jpg"),
		);
	}

    public function read($id) {
		return key_exists($id, $this->db)?$this->db[$id]:null;
	}

	public function readAll() {
		return $this->db;
	}
}