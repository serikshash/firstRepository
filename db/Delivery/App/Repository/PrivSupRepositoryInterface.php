<?php
interface PrivSupRepositoryInterface
{
public function getPrivSupList();
 public function getPrivSupByID($id);
 public function create($privSup);
 public function update($privSup);
 public function delete($id);
}
?>