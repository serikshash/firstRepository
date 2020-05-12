<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Supplier.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
require_once('SupplierRepositoryInterface.php');
class MySQLSupplierRepository implements SupplierRepositoryInterface
{
	public function getSupplierList()
	{
		$conn = MySQLConnectionUtil::getConnection();
		$suppliers = array();
		$query = 'SELECT id, name, address FROM supplier';
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$supplier = new Supplier($row['name'], $row['address']);
				$supplier->setId($row['id']);
				array_push($suppliers, $supplier);
			}
		mysqli_close($conn);
		return $suppliers;
	}
	public function getSupplierByID($id)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$supplier = NULL;
		$query = "SELECT id, name, address FROM supplier WHERE id = {$id}";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$supplier = new Supplier($row['name'], $row['address']);
				$supplier->setId($row['id']);
				break;
			}
		mysqli_close($conn);
		if ($supplier == NULL)
			{
				throw new Exception("Supplier with id {$id} doesn't exist!");
			}
		return $supplier;
	}
	public function getSupplierByName($name)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$supplier = NULL;
		$query = "SELECT id, name, address FROM supplier WHERE name = '{$name}'";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$supplier = new Supplier($row['name'], $row['address']);
				$supplier->setId($row['id']);
				break;
			}
		mysqli_close($conn);
		if ($supplier == NULL)
			{
				throw new Exception("Supplier with name {$name} doesn't exist!");
			}
		return $supplier;
	}
	public function create($supplier)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$name = $supplier->getName();
		$address = $supplier->getAddress();
		$query = "INSERT INTO supplier(name, address) VALUES ('{$name}', '{$address}')";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
		mysqli_close($conn);
	}
	public function update($supplier)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$id = $supplier->getId();
		$name = $supplier->getName();
		$address = $supplier->getAddress();
		$query = "UPDATE supplier SET name = '{$name}', address = '{$address}' WHERE id = {$id}";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
			mysqli_close($conn);
	}
	public function delete($id)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$query = "DELETE FROM supplier WHERE id = {$id}";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
		mysqli_close($conn);
	}
}
?>