<?php
namespace Src\MiniFramworkProject\Application\Model;


use Src\MiniFramworkProject\Application\Model\Picture;
use Src\MiniFramworkProject\Application\Model\PictureStorage;
class PictureStorageStub implements PictureStorage{
    protected $db;

	
	public function __construct() {
		/**
         * extraction des meta-données des images avec exiftool
         */
        $exiftool_data=Shell_exec("Src/Image-ExifTool-12.33/exiftool -json -g1 Src/Images");
        $data = json_decode($exiftool_data,true);
		$this->db=[];
		// var_dump($data);
		foreach($data as $key => $json_object){
			$title=$json_object['XMP-dc']['Title'];
			$description=$json_object['XMP-dc']['Description'];
			$size=$json_object['System']['FileSize'];
			$width=$json_object['File']['ImageWidth'];
			$height=$json_object['File']['ImageHeight'];
			$source_link=key_exists('Source',$json_object['IPTC'])?$json_object['IPTC']['Source']:null;
			$created_date_time=$json_object['XMP-photoshop']['DateCreated'];
			$last_modification=$json_object['System']['FileModifyDate'];
			$creator=$json_object['XMP-dc']['Creator'];
			$keywords_tags=$json_object['XMP-dc']['Subject'];
			$city=key_exists('City',$json_object['XMP-photoshop'])?$json_object['XMP-photoshop']['City']:null;
			$state=$json_object['XMP-photoshop']['State'];
			$country=$json_object['XMP-photoshop']['Country'];
			$gps_data=array($json_object['Composite']['GPSLatitude'],$json_object['Composite']['GPSLongitude'],$json_object['Composite']['GPSPosition']);
			$copy_rights=$json_object['ICC_Profile']['ProfileCopyright'];
			$usage_terms_link=$json_object['XMP-xmpRights']['UsageTerms'];

			$i=$key+1;
			$this->db[]= new Picture($title, "photo".$i.".jpg",$description,$size,$width,$height,$source_link,$created_date_time,
			$last_modification,$creator,$keywords_tags,$city,$state,$country,$gps_data,$copy_rights,$usage_terms_link);
		}
	}

    public function read($id) {
		return key_exists($id, $this->db)?$this->db[$id]:null;
	}

	public function readAll() {
		return $this->db;
	}
}