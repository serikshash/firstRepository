<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/LegSup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
require_once('LegSupRepositoryInterface.php');
class MySQLLegSupRepository implements LegSupRepositoryInterface{
   public function getLegSupList(){
     $conn = MySQLConnectionUtil::getConnection();
     $legSupA = array();
     $query = 'SELECT id, tax_number, vat_number FROM legal_supplier';
     $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result)){
       $legSup = new LegSup($row['id'], $row['tax_number'], $row['vat_number']);
       array_push($legSupA, $legSup);
     }
     mysqli_close($conn);
     return $legSupA;
   }
 public function getLegSupByID($id){
   $conn = MySQLConnectionUtil::getConnection();
   $legSup = NULL;
   $query = "SELECT id, tax_number, vat_number FROM legal_supplier WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
   while ($row = mysqli_fetch_assoc($result)){
     $legSup = new LegSup($row['id'], $row['tax_number'], $row['vat_number']);
     break;
   }
   mysqli_close($conn);
   if ($legSup == NULL){
   throw new Exception();
   }
   return $legSup;
 }
 public function create($legSup) {
   $conn = MySQLConnectionUtil::getConnection();
   $id = $legSup->getId();
   $taxNum = $legSup->getTaxNum();
   $vatNum = $legSup->getVatNum();   
   $query = "INSERT INTO legal_supplier(id, tax_number, vat_number) VALUES ({$id}, '{$taxNum}', '{$vatNum}')";
   $result = mysqli_query($conn, $query);
   if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
   mysqli_close($conn);
 }
 public function update($legSup){
   $conn = MySQLConnectionUtil::getConnection();
   $id = $legSup->getId();
   $taxNum = $legSup->getTaxNum();
   $vatNum = $legSup->getVatNum();
   
  $query = "UPDATE legal_supplier SET tax_number = '{$taxNum}',vat_number = '{$vatNum}' WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
   if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
 mysqli_close($conn);
 }
 
public function delete($id){
   $conn = MySQLConnectionUtil::getConnection();
   $query = "DELETE FROM legal_supplier WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
  if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
 mysqli_close($conn);
 }
}
?>