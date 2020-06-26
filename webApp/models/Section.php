<?php
/**
 * class Section for the section table
 */
class Section
{
	private $_id, $_sectionName, $_sectionStatus;
	

	public function __construct(array $data)
	{
		$this->hydrate($data);
	}

	public function hydrate($data)
	{
		foreach($data as $key => $value){
			$method = 'set'.ucfirst($key);

			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
	}

	public function getId(){
		return $this->_id;
	}

	public function setId($id){
		$this->_id = $id;
	}

	public function getSectionName(){
		return $this->_sectionName;
	}

	public function setSectionName($sectionName){
		$this->_sectionName = $sectionName;
	}

	public function getSectionStatus(){
		return $this->_sectionStatus;
	}

	public function setSectionStatus($sectionStatus){
		$this->_sectionStatus = $sectionStatus;
	}
}