<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
require_once('ProductRepositoryInterface.php');
class MySQLProductRepository implements ProductRepositoryInterface
{
	public function getListOfSuppliedProduct()
	{
		$conn = MySQLConnectionUtil::getConnection();
		$products = array();
		$query = 'SELECT contract, product, amount, price FROM product';
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$product = new Product($row['contract'], $row['product'], $row['amount'], $row['price']);
				array_push($products, $product);
			}
		mysqli_close($conn);
		return $products;
	}
	public function getListOfSuppliedProductByContract($contract)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$products = array();
		$query = "SELECT contract, product, amount, price FROM product WHERE contract={$contract}";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$product = new Product($row['contract'], $row['product'], $row['amount'], $row['price']);
				array_push($products, $product);
			}
		mysqli_close($conn);
		if ($product == NULL)
			{
				throw new Exception("Contract with number {$contract} doesn't exist!");
			}
		return $products;
	}
	public function getProduct($contract, $name)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$product = NULL;
		$query = "SELECT contract, product, amount, price FROM product WHERE contract = {$contract} AND product='{$name}'";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result))
			{
				$product = new Product($row['contract'], $row['product'], $row['amount'], $row['price']);
				break;
			}
		mysqli_close($conn);
		if ($product == NULL)
			{
				throw new Exception("Product with number of contract {$contract} and name {$name} don't exist!");
			}
			return $product;
	}
	public function create($product)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$contract = $product->getContract();
		$name = $product->getName();
		$amount = $product->getAmount();
		$price = $product->getPrice();
		$query = "INSERT INTO product(contract, product, amount, price) VALUES ({$contract}, '{$name}', {$amount}, '{$price}')";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
		mysqli_close($conn);
	}
	public function update($product)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$contract = $product->getContract();
		$name = $product->getName();
		$amount = $product->getAmount();
		$price = $product->getPrice();
		$query = "UPDATE product SET amount = {$amount}, price = {$price} WHERE contract = {$contract} AND product='{$name}'";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
			mysqli_close($conn);
	}
	public function deleteProduct($contract,$name)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$query = "DELETE FROM product WHERE product.contract = {$contract} AND product.product='{$name}'";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
		mysqli_close($conn);
	}
	public function deleteProductByContract($contract)
	{
		$conn = MySQLConnectionUtil::getConnection();
		$query = "DELETE FROM product WHERE contract = {$contract}";
		$result = mysqli_query($conn, $query);
		if (!$result)
			{
				throw new Exception(mysqli_error($conn));
			}
		mysqli_close($conn);
	}
}
?>