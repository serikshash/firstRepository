<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLContractRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ContractService.php');
session_start();
$_SESSION['username'] = 'supply_manager';
$_SESSION['password'] = 'supply';
class TestContractService
{
	private $repository;
	private $service;
	public function __construct()
	{
		$this->repository = new MySQLContractRepository();
		$this->service = new ContractService($this->repository);
	}
	
	public function shouldReturnContractByNumber()
	{ 
		echo "Return contract by ID 1";
		echo "<pre>";
		try
		{
			print_r($this->service->getContractByNumber(1));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldThrowExceptionWhenGetContractByUndefinedNumber()
	{
		echo "Return contract by undefined id";
		echo "<pre>";
		try
		{
			print_r($this->service->getContractByNumber(NULL));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldCreateContract()
	{ 
		echo "Create and return contract";
		echo "<pre>";
		try
		{			
			$this->service->createContract(-1, '2020-04-29', 1, 'test','test');
			print_r($this->service->getContractByNumber(16));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldUpdateContract()
	{ 
		echo "Update and return contract";
		echo "<pre>";
		try
		{			
			$this->service->updateContract(16, '2019-04-28', 1, 'test1','test');
			print_r($this->service->getContractByNumber(16));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldDeleteContract()
	{ 
		echo "Delete and try to return deleted contract";
		echo "<pre>";
		try
		{			
			$this->service->deleteContract(16);
			print_r($this->service->getContractByNumber(16));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}

}
$test = new TestContractService();
$test->shouldReturnContractByNumber();
$test->shouldThrowExceptionWhenGetContractByUndefinedNumber();
$test->shouldCreateContract();
$test->shouldUpdateContract();
$test->shouldDeleteContract();
?>