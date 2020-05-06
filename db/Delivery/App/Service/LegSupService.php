<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/LegSup.php');
require_once
($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/LegSupRepositoryInterface.php');
class LegSupService{
 	private $repository;
 	public function __construct(LegSupRepositoryInterface $repository){
 		$this->repository = $repository;
 	}
 	public function getAllLegSup(){
 		return $this->repository->getLegSupList();
 	}
 	public function getLegSupByID($id){
 		if (isset($id))	{
 	return $this->repository->getLegSupByID($id);
 	}
 	else{
 		throw new Exception("id is not valid ");
 	}
 }
 	public function createLegSup($id, $taxNum, $vatNum){
 		if (isset($id, $taxNum, $vatNum)){
 			$legSup = new LegSup($id, $taxNum, $vatNum);
 			$this->repository->create($legSup);
 		}
 		else{
 			throw new Exception();
 		}
 	}
 	public function updateLegSup($id, $taxNum, $vatNum){
 		if (isset($id, $taxNum, $vatNum)) 	{
 			$legSup = $this->repository->getLegSupByID($id);
 			$updated = new LegSup($id, $taxNum, $vatNum);
 			$this->repository->update($updated);
 		}
 		else{
 			throw new Exception();
 		}
 	}
 	public function deleteLegSup($id){
 		if (isset($id)){
 			$this->repository->delete($id);
 		}
 		else{
 			throw new Exception();
 		}
 	}
}
?>