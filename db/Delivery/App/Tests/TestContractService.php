<?php
require_once 
($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLContractRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ContractService.php');
session_start();
$_SESSION['username'] = 'supply_mngr';
$_SESSION['password'] = 'supply';
class TestContractService{
 	private $repository;
 	private $service;
 	public function __construct() {
 		$this->repository = new MySQLContractRepository();
 		$this->service = new ContractService($this->repository);
 	}
 	public function shouldReturnContractByNumber($id){
		try{
 			print_r($this->service->getContractByNumber($id));
 		}
 		catch (Exception $e){
 			echo $e->getMessage();
 		}
 	}
 	
}
$test = new TestContractService();
$test->shouldReturnContractByNumber(1);
$test->shouldReturnContractByNumber(null);
$test->shouldReturnContractByNumber(-1);

?>