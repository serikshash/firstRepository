<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLProductRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ProductService.php');
session_start();
$_SESSION['username'] = 'supply_mngr';
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
    try
    {
      print_r($this->service->getAllProducts());
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
    }
  }
  public function shouldCreateProduct()
  { 
    try{      
      $this->service->createProduct(7, 'TEST',100, 100);
     print_r($this->service->getProduct(7,'TEST'));
    }
    catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  public function shouldReturnException()
  { 
    try
    {      
      $this->service->createProduct(8, 'testing',-41, 100.2);
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
    }


  }

  //  public function shouldDel()
  // { 
  //   try
  //   {      
  //     $this->service->deleteProductByContract(7);
  //   }
  //   catch (Exception $e)
  //   {
  //     echo $e->getMessage();
  //   }

    
  // }
  
}
$test = new TestProductService();
$test->shouldReturnException();
print_r("//////////////////////////////////////////////////////////////////////////////");
$test->shouldReturnProducts();
print_r("//////////////////////////////////////////////////////////////////////////////");
$test->shouldCreateProduct();
print_r("//////////////////////////////////////////////////////////////////////////////");

?>