<?php
interface ContractRepositoryInterface
{
	public function getContractList();
	public function getContractListByProduct();
	public function getContractByNumber($number);
	public function create($contract);
	public function update($contract);
	public function delete($number);
}
?>