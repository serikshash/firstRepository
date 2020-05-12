<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLSupplierRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/SupplierService.php');
session_start();
$_SESSION['username'] = 'market_manager';
$_SESSION['password'] = 'marketing';
class TestSupplierService
{
	private $repository;
	private $service;
	public function __construct()
	{
		$this->repository = new MySQLSupplierRepository();
		$this->service = new SupplierService($this->repository);
	}
	public function shouldReturnSupplierByNumber()
	{ 		
		echo "Return suplier by ID 1";
		echo "<pre>";
		try
		{
			var_dump($this->service->getSupplierByID(1));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}

	public function shouldThrowExceptionWhenGetSupplierByInexistentNumber()
	{
		echo "Return suplier by ID -1";
		echo "<pre>";
		try
		{
			print_r($this->service->getSupplierByID(-1));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldCreateSupplier()
	{ 
		echo "Create and return suplier";
		echo "<pre>";
		try
		{			
			$this->service->createSupplier('test', 'test');
			print_r($this->service->getSupplierByName('test'));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	public function shouldDeleteSupplier()
	{ 
		echo "Delete and try to return deleted suplier";
		echo "<pre>";
		try
		{			
			$this->service->deleteSupplier(18);
			print_r($this->service->getSupplierByID(18));
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
		echo "</pre>";
	}
	
}
$test = new TestSupplierService();
$test->shouldReturnSupplierByNumber();
$test->shouldThrowExceptionWhenGetSupplierByInexistentNumber();
$test->shouldCreateSupplier();
$test->shouldDeleteSupplier();
?>