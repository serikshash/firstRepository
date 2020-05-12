<?php
interface ProductRepositoryInterface
{
	public function getListOfSuppliedProduct();
	public function getListOfSuppliedProductByContract($contract);
	public function getProduct($contract,$name);
	public function create($product);
	public function update($product);
	public function deleteProduct($contract,$name);
	public function deleteProductByContract($contract);
}
?>