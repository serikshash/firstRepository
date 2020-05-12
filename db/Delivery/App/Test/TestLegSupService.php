<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLLegSupRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/LegSupService.php');
session_start();
$_SESSION['username'] = 'market_manager';
$_SESSION['password'] = 'marketing';
class TestLegSupService{
   private $repository;
   private $service;
   public function __construct() {
     $this->repository = new MySQLLegSupRepository();
     $this->service = new LegSupService($this->repository);
   }
   public function shouldReturnLegSupByID(){
    echo "Legal Supplier by ID 3";
    echo "<pre>";
    try{
       print_r($this->service->getLegSupByID(3));
     }
     catch (Exception $e){
       echo $e->getMessage();
     }
   }
   public function shouldWorkTriggerWhenCreateLegSup(){
    echo "Try to create suplier who already a private";
    echo "<pre>";
     try{
      $this->service->createLegSup(1, '35687140', '36524p2p0');
    }
     catch (Exception $e){
       echo $e->getMessage();
     }
     echo "</pre>";
   }
   public function shouldReturnAllLegSup(){
    echo "All Legal Suppliers";
    echo "<pre>";
     try{
       print_r($this->service->getAllLegSup());
     }
     catch (Exception $e){
       echo $e->getMessage();
     }
    echo "</pre>";
   }
}
$test = new TestLegSupService();
$test->shouldReturnLegSupByID();
$test->shouldWorkTriggerWhenCreateLegSup();
$test->shouldReturnAllLegSup();

?>