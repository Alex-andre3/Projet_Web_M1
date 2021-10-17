<?php
namespace Src\MiniFramworkProject\Application\Model;


interface PictureStorage {
	public function read($id);
	public function readAll();
}