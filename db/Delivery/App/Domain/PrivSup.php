<?php
class PrivSup{
private $id;
private $fName;
private $sName;
private $lName;
private $regNum;

public function __construct($id, $fName, $sName, $lName,$regNum){
	if (empty($id))	{
		throw new Exception();
	}
	if (empty($fName)){
		throw new Exception();
	}
	if (empty($sName)){
		throw new Exception();
	}
	if (empty($lName)){
		throw new Exception();
	}
	if (empty($regNum)){
		throw new Exception();
	}
	$this->id = $id;
	$this->fName = $fName;
	$this->sName = $sName;
	$this->lName = $lName;
	$this->regNum = $regNum;
}
	public function getId(){
		return $this->id;
	}
	public function getFName(){
		return $this->fName;
	}
	public function getSName(){
		return $this->sName;
	}
	public function getLName(){
		return $this->lName;
	}
	public function getRegNum(){
		return $this->regNum;
	}
}
?>