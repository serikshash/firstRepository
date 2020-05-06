<?php
interface LegSupRepositoryInterface{
public function getLegSupList();
 public function getLegSupByID($id);
 public function create($legSup);
 public function update($legSup);
 public function delete($id);
}
?>