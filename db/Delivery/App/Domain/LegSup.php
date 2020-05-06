<?php
class LegSup{
private $id;
private $taxNum;
private $vatNum;

public function __construct($id, $taxNum, $vatNum){
	if (empty($id))	{
		throw new Exception();
	}
	if (empty($taxNum)){
		throw new Exception();
	}
	if (empty($vatNum)){
		throw new Exception();
	}

	$this->id = $id;
	$this->taxNum = $taxNum;
	$this->vatNum = $vatNum;
}
	public function getId(){
		return $this->id;
	}
	public function getTaxNum(){
		return $this->taxNum;
	}
	public function getVatNum(){
		return $this->vatNum;
	}
}
?>