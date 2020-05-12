<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLPrivSupRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/PrivSupService.php');
session_start();
$_SESSION['username'] = 'market_manager';
$_SESSION['password'] = 'marketing';
class TestLegSupService{
   private $repository;
   private $service;
   public function __construct() {
     $this->repository = new MySQLPrivSupRepository();
     $this->service = new PrivSupService($this->repository);
   }
   public function shouldReturnPrivSupByID(){
    echo "Private Supplier by ID 1";
    echo "<pre>";
    try{
       print_r($this->service->getPrivSupByID(1));
     }
     catch (Exception $e){
       echo $e->getMessage();
     }
     echo "</pre>";
   }
   public function shouldWorkTriggerWhenCreatePrivSup(){
    echo "Try to create private supplier";
    echo "<pre>";
     try{
      $this->service->createPrivSup(19, 'fn', 'ln', 'sn', '12541');
    }
     catch (Exception $e){
       echo $e->getMessage();
     }
     echo "</pre>";
   }
   public function shouldReturnAllPrivSup(){
    echo "All Private Suppliers";
    echo "<pre>";
     try{
       print_r($this->service->getAllPrivSup());
     }
     catch (Exception $e){
       echo $e->getMessage();
     }
    echo "</pre>";
   }
}
$test = new TestLegSupService();
$test->shouldReturnPrivSupByID();
$test->shouldWorkTriggerWhenCreatePrivSup();
$test->shouldReturnAllPrivSup();

?>