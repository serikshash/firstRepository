<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Supplier.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/SupplierRepositoryInterface.php');
class SupplierService
{
  private $repository;
  public function __construct(SupplierRepositoryInterface $repository)
  {
    $this->repository = $repository;
  }
  public function getAllSuppliers()
  {
    return $this->repository->getSupplierList();
  }
  public function getSupplierByID($id)
  {
    if (isset($id))
      {
        return $this->repository->getSupplierByID($id);
      }
      else
      {
        throw new Exception('Supplier id is undefined!');
      }
  }
  public function getSupplierByName($name)
  {
    if (isset($name))
      {
        return $this->repository->getSupplierByName($name);
      }
      else
      {
        throw new Exception('Supplier name is undefined!');
      }
  }
  public function createSupplier($name, $address)
  {
    if (isset($name, $address))
      {
        $supplier = new Supplier($name, $address);
        $this->repository->create($supplier);
      }
    else
      {
        throw new Exception('Please fill in all supplier fields!');
      }
  }
  public function updateSupplier($id, $name, $address)
  {
    if (isset($id, $name, $address))
      {
        $supplier = $this->repository->getSupplierByID($id);
        $updated  =  new  Supplier( $name, $address);
        $updated->setId($id);
        $this->repository->update($updated);
      }
    else
      {
        throw new Exception('Please fill in all supplier fields!');
      }
  }
  public function deleteSupplier($id)
  {
    if (isset($id))
      {
        $this->repository->delete($id);
      }
    else
      {
        throw new Exception('Supplier id is undefined!');
      }
  }
}
?>