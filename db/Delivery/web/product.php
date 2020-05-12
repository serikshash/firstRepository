<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Contract.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLContractRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ContractService.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Product.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLProductRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ProductService.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Supplier.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLSupplierRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/SupplierService.php');
if (!isset($_SESSION['username']))
	{
		$controller->redirect('login');
	}
$repository = new MySQLContractRepository();
$service = new ContractService($repository);

$repositoryP = new MySQLProductRepository();
$serviceP = new ProductService($repositoryP);

$repository1 = new MySQLSupplierRepository();
$serviceS = new SupplierService($repository1);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<link  rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head> 
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="./">Поставки</a>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="./contracts.php">Договори</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="./suppliers.php">Список постачальників</a>
				</li>

				<li class="nav-item active">
					<a class="nav-link" href="./legSupplier.php">Юр. особи</a>
				</li>

				<li class="nav-item active">
					<a class="nav-link" href="./privSupplier.php">Фіз. особи</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="./product.php">Поставлені продукти</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
				<button  class="btn  btn-outline-primary  my-2  my-sm-0" type="submit">Вийти</button>
			</form>
		</div>
	</nav>
	<div class="modal" tabindex="-1" role="dialog" id="alertModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="alert alert-danger" role="alert">
      		<p id="error"></p>
      	</div>        
      </div>
    </div>
  </div>
</div>
	<div class="row my-3 mx-1">
		<div class="col-4">
			<ul class="list-group">
				<li class="list-group-item active">Договори на поставку</li>
				<?php  foreach ($service->getAllContractsWithProducts() as $contract) { ?>
					<li class="list-group-item">
						<a href="product.php?details=<?= $contract->getNumber() ?>">
							#<?= $contract->getNumber() ?>, <?= $contract->getAgreed() ?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?>
						</a>
					</li>
					<?php } ?>
			</ul>
		</div>
		<div class="col-8">
<?php
if (isset($_GET['details']))
{
	try
	{
		$contracts = @$service->getContractByNumber($_GET['details']);

?>
<h5> Поставка від <?= $contracts->getAgreed()?> по договору #<?= $contracts->getNumber() ?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?> </h5>
<div><a class="btn btn-success <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="product.php?newProduct=<?= $contracts->getNumber() ?>" role="button">Новий товар</a> </div>
<br>
	<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Товар</th>
      <th scope="col">Кількість</th>
      <th scope="col">Ціна</th>
    </tr>
  </thead>
  <tbody>
  	<?php 
  	$ind=1;
  	$sum=0; 
  	foreach ($serviceP->getAllProductsByContract($_GET['details']) as $contract) { ?>
  		<tr>
      <th scope="row"><?= $ind++ ?></th>
      <td><?= $contract->getName() ?></td>
      <td><?= $contract->getAmount() ?></td>
      <td><?= $contract->getPrice() ?></td>
      <td><a class="btn btn-warning <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="product.php?editPr=<?= $contract->getContract()?>&n=<?= $contract->getName()?>"  role="button">Редагувати</a>
<a class="btn btn-danger <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="product.php?deletePr=<?= $contract->getContract() ?>&n=<?= $contract->getName()?>" role="button" >Видалити</a></td>
    </tr>
<?php 
 $sum+=$contract->getAmount()*$contract->getPrice();} ?>
 <tr>
  	 <th scope="row" colspan="3" class="table-success" align="right" >Сумарна вартість:</th>
  	 <th class="table-success"> <?= $sum ?> </th>
  	 <tr>
  </tbody>
</table>
<?php
}
catch (Exception $e)
{
?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
}
}
else
{
if (isset($_GET['newProduct']))
 	{
 		try
	{
		$contracts = @$service->getContractByNumber($_GET['newProduct']);
 		?>
 		<form action="product.php" method="post">
 			<h5> Поставка від <?= $contracts->getAgreed()?> по договору #<?= $contracts->getNumber() ?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?> </h5>
 			<input  type="text" class="form-control" id="number" name="contract" value="<?= $contracts->getNumber() ?>" hidden>	
 		<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Назва товару</label>
		<div class="col-sm-10">
			<input  type="text"  class="form-control" id="name" name="name"  required>
		</div>
	</div>
	<div class="form-group row">
		<label for="amount" class="col-sm-2 col-form-label">Кількість</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" id="amount" name="amount" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="price" class="col-sm-2 col-form-label">Ціна</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" rows="5" id="price" name="price" required>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" name="savePr">Додати!</button>
	<a class="btn btn-secondary" href="product.php?details=<?= $contracts->getNumber() ?>" role="button" >Назад</a> 
</form> 
<?php
} catch(Exception $e)
{
?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
} 	
} else{
	if(isset($_GET['editPr'])&& isset($_GET['n']))
	{
		try
 		{
 			$contracts = @$service->getContractByNumber($_GET['editPr']);
 		$product =@$serviceP-> getProduct($_GET['editPr'], $_GET['n']);?>

 			<form action="product.php" method="post">
 	<h5> Поставка від <?= $contracts->getAgreed()?> по договору #<?= $contracts->getNumber() ?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?> </h5>
 			<input  type="text" class="form-control" id="number" name="contract" value="<?= $contracts->getNumber() ?>" hidden>	
 		<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Назва товару</label>
		<div class="col-sm-10">
			<input  type="text"  class="form-control" id="name" name="name"  required value="<?= htmlspecialchars($product->getName()) ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="amount" class="col-sm-2 col-form-label">Кількість</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" id="amount" name="amount" required value="<?=$product->getAmount() ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="price" class="col-sm-2 col-form-label">Ціна</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" rows="5" id="price" name="price" required value="<?=$product->getPrice() ?>">
		</div>
	</div>
	<button type="submit" class="btn btn-primary" name="updatePr">Зберегти</button>
	<a class="btn btn-secondary" href="product.php?details=<?= $contract->getNumber() ?>" role="button" >Назад</a> 
	</form> 
 		<?php }
 		catch(Exception $e)
 		{?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
 		}
	}else{
		if(isset($_GET['new'])){
			try{
				?>
				<form action="product.php" method="post">
 		<div class="form-group row">
		<label  for="contract"  class="col-sm-2  col-formlabel">Поставка</label>
		<div class="col-sm-10">
			<select class="form-control" id="contract" name="contract" required>
				<?php foreach ($service->getAllContracts() as $contract) { ?>
					<option value="<?= $contract->getNumber() ?>" ><?= $contract->getNumber() ?>, <?= $contract->getAgreed()?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?></option>
					<?php } ?>
			</select>
		</div>
	</div>
 		<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Назва товару</label>
		<div class="col-sm-10">
			<input  type="text"  class="form-control" id="name" name="name"  required>
		</div>
	</div>
	<div class="form-group row">
		<label for="amount" class="col-sm-2 col-form-label">Кількість</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" id="amount" name="amount" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="price" class="col-sm-2 col-form-label">Ціна</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" rows="5" id="price" name="price" required>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" name="savePr">Зберегти</button>
	<a class="btn btn-secondary" href="product.php" role="button" >Назад</a> 
</form> 
			<?php }
 		catch(Exception $e)
 		{?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
		}
	}
		else{
?><a class="btn btn-success <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="product.php?new" role="button">Нова поставка</a><?php

 	}
 }
}
}
if (isset($_GET['deletePr']) && isset($_GET['n']))
 {
 	try
 	{
 		$contracts = @$service->getContractByNumber($_GET['deletePr']);
 		$name=strval($_GET['n']);?>
 		<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Ви дійсно хочете видалити товар <?= $name?>  в поставці від <?= $contracts->getAgreed()?> по договору #<?= $contracts->getNumber() ?>, <?= $serviceS->getSupplierByID($contract->getSupplier())->getName() ?>?</p>
      </div>
      <div class="modal-footer">
      	<form action="product.php" method="post">
      		<input type="text" hidden name="number" value="<?=$contract->getNumber()?>">
      		<input type="text" hidden name="name" value="<?=$name?>">
        <button type="submit" class="btn btn-primary" name="deletePr">Далі</button>
    </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Назад</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('#deleteModal').modal('show');
</script>
<?php 	}
 	catch(Exception $e)
 	{
?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
}
}
if(isset($_POST['savePr']))
 {
 	try{
 		@$serviceP->createProduct($_POST['contract'],$_POST['name'],$_POST['amount'],$_POST['price']);?>
 		<script type="text/javascript">
 			window.location.reload();
 			window.location.reload();
 			return 0;
 		</script>
 		<?php
 	}
 	catch(Exception $e)
 	{ 		
 		?>
 		
 		<script type="text/javascript">
 			$("#error").html("<?php echo $e->getMessage() ?>");
 				$('#alertModal').modal('show');
 		$('#alertModal').on('hidden.bs.modal', function (e) {
 			history.back();
})
</script>
<?php
 	} 	
 }

 if(isset($_POST['deletePr']))
 {
 	try{
 		@$serviceP->deleteProduct($_POST['number'], $_POST['name']);?>
 		<script type="text/javascript">
 			window.location.reload();
 			return 0;
 		</script>
 			<?php
 	}
 	catch(Exception $e)
 	{ 		
 		?>
 		
 		<script type="text/javascript">
 			$("#error").html("<?php echo $e->getMessage() ?>");
 				$('#alertModal').modal('show');
 		$('#alertModal').on('hidden.bs.modal', function (e) {
 			history.back();
})
</script>
<?php
 	} 	
 }
 if(isset($_POST['updatePr']))
 {
 	try{
 		@$serviceP->updateProduct($_POST['contract'],$_POST['name'],$_POST['amount'],$_POST['price']);?>
 		<script type="text/javascript">
 			window.location.reload();
 			return 0;
 		</script>
 			<?php
 	}
 	catch(Exception $e)
 	{ 		
 		?>
 		
 		<script type="text/javascript">
 			$("#error").html("<?php echo $e->getMessage() ?>");
 				$('#alertModal').modal('show');
 		$('#alertModal').on('hidden.bs.modal', function (e) {
 			history.back();
})
</script>
<?php
}
}
?>
</div>
</div>
</body>
</html>