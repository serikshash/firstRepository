<?php
require_once 
($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLegSupRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/LegSupService.php');
session_start();
$_SESSION['username'] = 'marketing';
$_SESSION['password'] = 'marketing';
class TestLegSupService{
 	private $repository;
 	private $service;
 	public function __construct() {
 		$this->repository = new MySQLegSupRepository();
 		$this->service = new LegSupService($this->repository);
 	}
 	public function shouldReturnLegSupByID($id){
		try{
 			print_r($this->service->getLegSupByID($id));
 		}
 		catch (Exception $e){
 			echo $e->getMessage();
 		}
 	}

 	public function shouldAdd(){
 		try{

 			print_r($this->service->createLegSup(17, "1478523697","123456789123"));
		}
 		catch (Exception $e){
 			echo $e->getMessage();
 		}
 	}
 	public function shouldDel($id){
 		try{

 			print_r($this->service->deleteLegSup($id));
		}
 		catch (Exception $e){
 			echo $e->getMessage();
 		}
 	}

}
$test = new TestLegSupService();
$test->shouldReturnLegSupByID(3);
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldReturnLegSupByID(null);
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldReturnLegSupByID(-1);
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldAdd();
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldReturnLegSupByID(17);
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldDel(17);
print_r("///////////////////////////////////////////////////////////////////////////");
$test->shouldReturnLegSupByID(17);
print_r("///////////////////////////////////////////////////////////////////////////");
?>