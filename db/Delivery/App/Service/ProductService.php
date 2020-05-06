<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/ProductRepositoryInterface.php');
class ProductService
{
  private $repository;
  public function __construct(ProductRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }
  public function getAllProducts()
  {
    return $this->repository->getListOfSuppliedProduct();
  }
  public function getAllProductsByContract($contract)
  {
    if (isset($contract))
      {
        return $this->repository->getListOfSuppliedProductByContract($contract);
      }
      else
      {
        throw new Exception('Contract number is undefined!');
      }
  }
  public function getProduct($contract,$name){
    if (isset($contract,$name))
      {
        return $this->repository->getProduct($contract,$name);
      }
      else
      {
        throw new Exception('Contract number and product name is undefined!');
      }
  }
  public function createProduct($contract, $name, $amount, $price)
  {
    if (isset($contract, $name, $amount, $price))
      {
        $agreed = date('Y-m-d');
        $product = new Product($contract, $name, $amount, $price);
        $this->repository->create($product);
      }
    else
      {
        throw new Exception('Please fill in all product fields!');
      }
  }
  public function updateProduct($contract, $name, $amount, $price)
  {
    if (isset($contract, $name, $amount, $price))
      {
        $product = $this->repository->getProduct($contract, $name);
        $updated  =  new Product($contract, $name, $amount, $price);
        $this->repository->update($updated);
      }
    else
      {
        throw new Exception('Please fill in all product fields!');
      }
  }
  public function deleteProduct($contract,$name)
  {
    if (isset($contract,$name))
      {
        $this->repository->delete($contract,$name);
      }
    else
      {
        throw new Exception('Contract and name is undefined!');
      }
  }
  public function deleteProductByContract($contract)
  {
    if (isset($contract))
      {
        $this->repository->deleteProductByContract($contract);
      }
    else
      {
        throw new Exception('Contract is undefined!');
      }
  }
}
?>