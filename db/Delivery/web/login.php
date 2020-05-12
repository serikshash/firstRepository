<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Util/MySQLConnectionUtil.php');
if (isset($_SESSION['username']))
{
	$controller->redirect ($_SESSION['username']);
}
if(isset($_POST['signin']))
{
	$_SESSION['username']=$_POST['username'];
	$_SESSION['password']=$_POST['password'];

	try
	{
		@MySQLConnectionUtil::getConnection();
		$controller->redirect($_SESSION['username']);
	}
	catch(Exception $e)
	{
		session_unset();
		session_destroy();
		?><div class="alert alert-danger" role="alert"><?= $e->getMessage()?></div><?php
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Contracts</title>
<link  rel="stylesheet" 
href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<div id="loginAlert" hidden>
		<div class="alert alert-danger" role="alert" id="loginErrorMessage"></div>
	</div>
	<div class="mt-5" id="signIn" hidden>
		<center>
			<a  class="btn  btn-success"  href="./"  role="button">Continue  as  <span id="continueUsername"></span></a>
		</center>
	</div>
<form class="col-md-6 offset-md-3 mt-5" method="post" id="loginForm">
	<div class="form-group row">
		<label for="inputEmail3" class="col-sm-2 col-form-label">Имя пользователя</label>
		<div class="col-sm-10">
			<input  type="text"  class="form-control"  id="inputUsername"  name="username" placeholder="User name">
		</div>
	</div>
	<div class="form-group row">
		<label for="inputPassword3" class="col-sm-2 col-form-label">Пароль</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-10">
			<input type="submit" class="btn btn-primary" value="Войти" name="signin">
		</div>
	</div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/login.js"></script>
</body>
</html>