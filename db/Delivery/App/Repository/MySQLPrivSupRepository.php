<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/PrivSup.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
require_once('PrivSupRepositoryInterface.php');
class MySQLPrivSupRepository implements PrivSupRepositoryInterface{
   public function getPrivSupList(){
     $conn = MySQLConnectionUtil::getConnection();
     $privSupA = array();
     $query = 'SELECT id, first_name, second_name, last_name, reg_number FROM private_supplier';
 
    $result = mysqli_query($conn, $query);
     while ($row = mysqli_fetch_assoc($result))
     {
       $privSup = new PrivSup($row['id'], $row['first_name'], $row['second_name'],$row['last_name'], $row['reg_number']);
       array_push($privSupA, $privSup);
     }
     mysqli_close($conn);
     return $privSupA;
   }
 public function getPrivSupByID($id){
   $conn = MySQLConnectionUtil::getConnection();
   $privSup = NULL;
   $query = "SELECT id, first_name, second_name, last_name, reg_number FROM private_supplier
   WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
   while ($row = mysqli_fetch_assoc($result)){
     $privSup = new PrivSup($row['id'], $row['first_name'], $row['second_name'],$row['last_name'], $row['reg_number']);
     break;
   }
   mysqli_close($conn);
   if ($privSup == NULL){
   throw new Exception();
   }
   return $privSup;
 }
 public function create($privSup) {
   $conn = MySQLConnectionUtil::getConnection();
   $id = $privSup->getId();
   $FName = $privSup->getFName();
   $SName = $privSup->getSName();
   $LName = $privSup->getLName();
   $RegNum = $privSup->getRegNum();
   $query = "INSERT INTO private_supplier(id, first_name, second_name, last_name, reg_number) VALUES ({$id}, '{$FName}', '{$SName}', '{$LName}', '{$RegNum}')";
   $result = mysqli_query($conn, $query);
   if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
   mysqli_close($conn);
 }
 public function update($privSup){
   $conn = MySQLConnectionUtil::getConnection();
   $id = $privSup->getId();
   $FName = $privSup->getFName();
   $SName = $privSup->getSName();
   $LName = $privSup->getLName();
   $RegNum = $privSup->getRegNum();
  $query = "UPDATE private_supplier SET first_name = '{$FName}', second_name = '{$SName}', last_name = '{$LName}', reg_number = '{$RegNum}' WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
   if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
 mysqli_close($conn);
 }
 
public function delete($id){
   $conn = MySQLConnectionUtil::getConnection();
   $query = "DELETE FROM private_supplier WHERE id = {$id}";
   $result = mysqli_query($conn, $query);
  if (!$result)   {
     throw new Exception(mysqli_error($conn));
   }
 mysqli_close($conn);
 }
}
?>