<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/PrivSup.php');
require_once
($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/PrivSupRepositoryInterface.php');
class PrivSupService{
   private $repository;
   public function __construct(PrivSupRepositoryInterface $repository){
     $this->repository = $repository;
   }
   public function getAllPrivSup(){
     return $this->repository->getPrivSupList();
   }
   public function getPrivSupByID($id){
     if (isset($id))  {
   return $this->repository->getPrivSupByID($id);
   }
   else{
     throw new Exception();
   }
 }
   public function createPrivSup($id, $fName, $sName, $lName, $regNum){
     if (isset($id, $fName, $sName, $lName, $regNum)){
       $privSup = new PrivSup($id, $fName, $sName, $lName, $regNum);
       $this->repository->create($privSup);
     }
     else{
       throw new Exception();
     }
   }
   public function updatePrivSup($id, $fName, $sName, $lName, $regNum){
     if (isset($id, $fName, $sName, $lName, $regNum))   {
       $privSup = $this->repository->getPrivSupByID($id);
       $updated = new PrivSup($id, $fName, $sName, $lName, $regNum);
       $this->repository->update($updated);
     }
     else{
       throw new Exception();
     }
   }
   public function deletePrivSup($id){
     if (isset($id)){
       $this->repository->delete($id);
     }
     else{
       throw new Exception();
     }
   }
}
?>