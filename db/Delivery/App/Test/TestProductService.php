<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLProductRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ProductService.php');
session_start();
$_SESSION['username'] = 'supply_manager';
$_SESSION['password'] = 'supply';
class TestProductService
{
	private $repository;
	private $service;
	public function __construct()
	{
		$this->repository = new MySQLProductRepository();
		$this->service = new ProductService($this->repository);
	}

	public function shouldReturnProducts()
	{ 
		echo "All products";
		try
		{
			echo "<pre>";
			var_dump($this->service->getAllProducts());
			echo "</pre>";

		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function shouldCreateProduct()
	{ 
		echo "<br>Create and Return ";
		try
		{			
			$this->service->createProduct(8, 'test',42, 100.2);
			echo "<pre>";
			var_dump($this->service->getProduct(8,'test'));
			echo "</pre>";
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function shouldReturnExceptionTrigger()
	{ 
		echo "<br> Create exception";
		try
		{			
			$this->service->createProduct(8, 'testing',-41, 100.2);
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function shouldUpdateProduct()
	{ 
		echo "<br> Update and Return ";
		try
		{			
			$this->service->updateProduct(8, 'test',35, 44);
			echo "<pre>";
			var_dump($this->service->getProduct(8,'test'));
			echo "</pre>";
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
	public function shouldDeleteProduct()
	{ 
		echo "<br> Delete and Try to Return ";
		try
		{			
			$this->service->deleteProduct(8, 'test');
			echo "<pre>";
			var_dump($this->service->getProduct(8,'test'));
			echo "</pre>";
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
	
}
$test = new TestProductService();
$test->shouldReturnProducts();
$test->shouldCreateProduct();
$test->shouldReturnExceptionTrigger();
$test->shouldUpdateProduct();
$test->shouldDeleteProduct();
?>