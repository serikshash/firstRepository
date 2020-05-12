<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Contract.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/ContractRepositoryInterface.php');
class ContractService
{
	private $repository;
	public function __construct(ContractRepositoryInterface $repository)
	{
		$this->repository = $repository;
	}
	public function getAllContracts()
	{
		return $this->repository->getContractList();
	}
	public function getAllContractsWithProducts()
	{
		return $this->repository->getContractListByProduct();
	}
	public function getContractByNumber($number)
	{
		if (isset($number))
			{
				return $this->repository->getContractByNumber($number);
			}
			else
			{
				throw new Exception('Contract number is undefined!');
			}
	}
	public function createContract($number,$agreed, $supplier, $title, $note)
	{
		if (isset($number,$agreed, $supplier, $title, $note))
			{
				//$agreed = date('Y-m-d');
				$contract = new Contract($number, $agreed, $supplier, $title, $note);
				$this->repository->create($contract);
			}
		else
			{
				throw new Exception('Please fill in all contract fields!');
			}
	}
	public function updateContract($number,$agreed, $supplier, $title, $note)
	{
		if (isset($number, $supplier, $title, $note))
			{
				//$contract = $this->repository->getContractByNumber($number);
				//$agreed = date('Y-m-d');
				$updated  =  new Contract($number,  $agreed,  $supplier,  $title, $note);
				$this->repository->update($updated);
			}
		else
			{
				throw new Exception('Please fill in all contract fields!');
			}
	}
	public function deleteContract($number)
	{
		if (isset($number))
			{
				$this->repository->delete($number);
			}
		else
			{
				throw new Exception('Contract number is undefined!');
			}
	}
}
?>