<?php
class Product
{
private $contract;
private $name;
private $amount;
private $price;


public function __construct($contract, $name, $amount, $price)
{
  if (empty($amount))  {
    throw new Exception('Amount is not set!');
  }
  if (empty($contract)){
    throw new Exception('Contract number is not set!');
  }
  if (empty($price)){
    throw new Exception('Price is not set!');
  }
  if (empty($name)){
    throw new Exception('Name of product is not set!');
  }  
  $this->contract = $contract;
  $this->name = $name;
  $this->amount = $amount;
  $this->price = $price;  
}
  public function getAmount()
  {
    return $this->amount;
  }
  public function getContract()
  {
    return $this->contract;
  }
  public function getPrice()
  {
    return $this->price;
  }
  public function getName()
  {
    return $this->name;
  }
}
?>