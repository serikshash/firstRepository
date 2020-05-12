<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Controller.php');
session_unset();
session_destroy();
$controller->redirect('login');
?>