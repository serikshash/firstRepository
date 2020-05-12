<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Controller.php');
if (isset($_SESSION['username']))
{
$controller->redirect($_SESSION['username']);
}
else
{
$controller->redirect('login');
}
?>