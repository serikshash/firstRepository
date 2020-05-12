<?php
interface SupplierRepositoryInterface
{
	public function getSupplierList();
	public function getSupplierByID($id);
	public function getSupplierByName($name);
	public function create($supplier);
	public function update($supplier);
	public function delete($supplier);
}
?>