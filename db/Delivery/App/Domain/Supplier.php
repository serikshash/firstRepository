<?php
class Supplier
{
	private $id;
	private $name;
	private $address;
	public function __construct($name, $address)
	{
		if (empty($name)){
				throw new Exception('Supplier name is not set!');
			}
		if (empty($address)){
				throw new Exception('Supplier address is not set!');
			}
		$this->name = $name;
		$this->address = $address;
	}
	public function setId($id){
		if (empty($id)){
				throw new Exception('Supplier id is not set!');
			}
		$this->id = $id;
	}
	public function getId()	{
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getAddress(){
		return $this->address;
	}
}
?>