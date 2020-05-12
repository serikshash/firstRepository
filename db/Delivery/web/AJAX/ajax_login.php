<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
$_SESSION['username'] = $_GET['username'];
$_SESSION['password'] = $_GET['password'];
try
{
	@MySQLConnectionUtil::getConnection();
	echo json_encode(array('status' => 'true'));
}
catch (Exception $e)
{
	session_unset();
	session_destroy();
	echo json_encode(array('status' => 'false', 'message' => $e->getMessage()));
}
?>