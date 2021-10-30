<?php
namespace Src\MiniFramworkProject\Application\Model;


class Picture{

    private $title;
	private $name;
	private $description;
	private $size;
	private $width;
	private $height;
	private $source_link;
	private $created_date_time;
	private $last_modification;
	private $creator;
	private $keywords_tags;
	private $city;
	private $state;
	private $country;
	private $gps_data;
	private $copy_rights;
	private $usage_terms;
	

    public function __construct($title, $name,$description,$size,$width,$height,$source_link,$created_date_time,$last_modification,
	$creator,$keywords_tags,$city,$state,$country,$gps_data,$copy_rights,$usage_terms) {
		$this->title = $title;
		$this->name = $name;
		$this->description = $description;
		$this->size = $size;
		$this->width = $width;
		$this->height = $height;
		$this->source_link = $source_link;
		$this->created_date_time = $created_date_time;
		$this->last_modification = $last_modification;
		$this->creator = $creator;
		$this->keywords_tags = $keywords_tags;
		$this->city = $city;
		$this->state = $state;
		$this->country = $country;
		$this->gps_data = $gps_data;
		$this->copy_rights = $copy_rights;
		$this->usage_terms = $usage_terms;
	}

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

	/**
	 * Get the value of name
	 */ 
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @return  self
	 */ 
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of description
	 */ 
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set the value of description
	 *
	 * @return  self
	 */ 
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get the value of size
	 */ 
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * Set the value of size
	 *
	 * @return  self
	 */ 
	public function setSize($size)
	{
		$this->size = $size;

		return $this;
	}

	/**
	 * Get the value of width
	 */ 
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * Set the value of width
	 *
	 * @return  self
	 */ 
	public function setWidth($width)
	{
		$this->width = $width;

		return $this;
	}

	/**
	 * Get the value of height
	 */ 
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * Set the value of height
	 *
	 * @return  self
	 */ 
	public function setHeight($height)
	{
		$this->height = $height;

		return $this;
	}

	/**
	 * Get the value of source_link
	 */ 
	public function getSource_link()
	{
		return $this->source_link;
	}

	/**
	 * Set the value of source_link
	 *
	 * @return  self
	 */ 
	public function setSource_link($source_link)
	{
		$this->source_link = $source_link;

		return $this;
	}

	/**
	 * Get the value of created_date_time
	 */ 
	public function getCreated_date_time()
	{
		return $this->created_date_time;
	}

	/**
	 * Set the value of created_date_time
	 *
	 * @return  self
	 */ 
	public function setCreated_date_time($created_date_time)
	{
		$this->created_date_time = $created_date_time;

		return $this;
	}

	/**
	 * Get the value of last_modification
	 */ 
	public function getLast_modification()
	{
		return $this->last_modification;
	}

	/**
	 * Set the value of last_modification
	 *
	 * @return  self
	 */ 
	public function setLast_modification($last_modification)
	{
		$this->last_modification = $last_modification;

		return $this;
	}

	/**
	 * Get the value of creator
	 */ 
	public function getCreator()
	{
		return $this->creator;
	}

	/**
	 * Set the value of creator
	 *
	 * @return  self
	 */ 
	public function setCreator($creator)
	{
		$this->creator = $creator;

		return $this;
	}

	/**
	 * Get the value of keywords_tags
	 */ 
	public function getKeywords_tags()
	{
		return $this->keywords_tags;
	}

	/**
	 * Set the value of keywords_tags
	 *
	 * @return  self
	 */ 
	public function setKeywords_tags($keywords_tags)
	{
		$this->keywords_tags = $keywords_tags;

		return $this;
	}

	/**
	 * Get the value of city
	 */ 
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * Set the value of city
	 *
	 * @return  self
	 */ 
	public function setCity($city)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * Get the value of state
	 */ 
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Set the value of state
	 *
	 * @return  self
	 */ 
	public function setState($state)
	{
		$this->state = $state;

		return $this;
	}

	/**
	 * Get the value of country
	 */ 
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * Set the value of country
	 *
	 * @return  self
	 */ 
	public function setCountry($country)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Get the value of gps_data
	 */ 
	public function getGps_data()
	{
		return $this->gps_data;
	}

	/**
	 * Set the value of gps_data
	 *
	 * @return  self
	 */ 
	public function setGps_data($gps_data)
	{
		$this->gps_data = $gps_data;

		return $this;
	}

	/**
	 * Get the value of copy_rights
	 */ 
	public function getCopy_rights()
	{
		return $this->copy_rights;
	}

	/**
	 * Set the value of copy_rights
	 *
	 * @return  self
	 */ 
	public function setCopy_rights($copy_rights)
	{
		$this->copy_rights = $copy_rights;

		return $this;
	}

	/**
	 * Get the value of usage_terms
	 */ 
	public function getUsage_terms()
	{
		return $this->usage_terms;
	}

	/**
	 * Set the value of usage_terms
	 *
	 * @return  self
	 */ 
	public function setUsage_terms($usage_terms)
	{
		$this->usage_terms = $usage_terms;

		return $this;
	}
}