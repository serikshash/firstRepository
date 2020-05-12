<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Contract.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLContractRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/ContractService.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Domain/Supplier.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLSupplierRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/SupplierService.php');
if (!isset($_SESSION['username']))
	{
		$controller->redirect('login');
	}
$repository = new MySQLContractRepository();
$service = new ContractService($repository);
$repository1 = new MySQLSupplierRepository();
$serviceS = new SupplierService($repository1);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contracts</title>
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
				<!-- <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Постачальники</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="./suppliers.php">Список постачальників</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="./legSupplier.php">Юр. особи</a>
						<a class="dropdown-item" href="./privSupplier.php">Фіз. особи</a>
					</div>
				</li> -->


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
				<li class="list-group-item active">Договори</li>
				<?php  foreach ($service->getAllContracts() as $contract) { ?>
					<li class="list-group-item">
						<a href="contracts.php?details=<?= $contract->getNumber() ?>">
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
		$contract = @$service->getContractByNumber($_GET['details']);
		$supplier = @$serviceS->getSupplierByID($contract->getSupplier());
?>
<form>
	<div class="form-group row">
		<label  for="contractNumber"  class="col-sm-2  col-formlabel">Номер договора</label>
		<div class="col-sm-10">
			<input  type="text"  readonly  class="form-control-plaintext" id="contractNumber" value="<?= $contract->getNumber() ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="contractDate" class="col-sm-2 col-form-label">Дата укладення договора</label>
		<div class="col-sm-10">
			<input  type="text"  readonly  class="form-control-plaintext" id="contractDate" value="<?= $contract->getAgreed() ?>">
		</div>
	</div>
	<div class="form-group row">
		<label  for="supplier"  class="col-sm-2  col-formlabel">Постачальник</label>
		<div class="col-sm-10">
			<input  type="text"  readonly  class="form-control-plaintext" id="supplier" value="<?= htmlspecialchars($supplier->getName()) ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="title" class="col-sm-2 col-form-label">Назва </label>
		<div class="col-sm-10">
			<input  type="text"  readonly  class="form-control-plaintext" id="title" value="<?= htmlspecialchars($contract->getTitle()) ?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="note" class="col-sm-2 col-form-label">Нотатки</label>
		<div class="col-sm-10">
			<textarea class="form-control" readonly rows="5" id="note"><?= htmlspecialchars($contract->getNote()) ?></textarea>
		</div>
	</div>
</form> 
<a class="btn btn-warning <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="contracts.php?edit=<?= $contract->getNumber() ?>"  role="button">Редагувати</a>
<a class="btn btn-danger <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="contracts.php?delete=<?= $contract->getNumber() ?>" role="button" >Видалити</a>
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
if (isset($_GET['new']))
 	{?>
 		<form action="contracts.php" method="post">
 			<input  type="text" class="form-control" id="number" name="number" value="1" hidden> 	
	<div class="form-group row">
		<label for="contractDate" class="col-sm-2 col-form-label">Дата укладення договора</label>
		<div class="col-sm-10">
			<input  type="date"  class="form-control" id="contractDate" name="agreed"  required>
		</div>
	</div>
	<div class="form-group row">
		<label  for="supplier"  class="col-sm-2  col-formlabel">Постачальник</label>
		<div class="col-sm-10">
			<select class="form-control" id="supplier" name="supplier" required>
				<?php foreach ($serviceS->getAllSuppliers() as $supplier) { ?>
					<option value="<?= $supplier->getId() ?>" ><?= $supplier->getName() ?></option>
					<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="title" class="col-sm-2 col-form-label">Назва</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" id="title" name="title" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="note" class="col-sm-2 col-form-label">Нотатки</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="5" id="note" name="note" required></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" name="saveC">Зберегти</button>
	<a class="btn btn-secondary" href="contracts.php ?>" role="button" >Назад</a> 
</form> 
<?php 	} else{
	if(isset($_GET['edit']))
	{
		try
 		{
 			$contract = @$service->getContractByNumber($_GET['edit']);
 			$supplier = @$serviceS->getSupplierByID($contract->getSupplier());?>
 			<form action="contracts.php" method="post">
 	<div class="form-group row">
		<label  for="contractNumber"  class="col-sm-2  col-formlabel">Номер договора</label>
		<div class="col-sm-10">
			<input  type="text"  readonly  class="form-control" id="contractNumber" name="number" value="<?= $contract->getNumber() ?>">
		</div>
</div>
	<div class="form-group row">
		<label for="contractDate" class="col-sm-2 col-form-label">Дата укладення договора</label>
		<div class="col-sm-10">
			<input  type="date"  class="form-control" id="contractDate" name="agreed" value="<?= $contract->getAgreed() ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label  for="supplier"  class="col-sm-2  col-formlabel">Постачальник</label>
		<div class="col-sm-10">
			<select class="form-control" id="supplier" name="supplier" required>
				<?php foreach ($serviceS->getAllSuppliers() as $supplier) { ?>
					<option value="<?= $supplier->getId() ?>"<?php if($supplier->getId()==$contract->getSupplier()) echo "selected"; ?> ><?= $supplier->getName() ?></option>
					<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="title" class="col-sm-2 col-form-label">Назва</label>
		<div class="col-sm-10">
			<input  type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($contract->getTitle()) ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label for="note" class="col-sm-2 col-form-label">Нотатки</label>
		<div class="col-sm-10">
			<textarea class="form-control" rows="5" id="note" name="note" required> <?= htmlspecialchars($contract->getNote()) ?></textarea>
		</div>
	</div>
	<button type="submit" class="btn btn-primary" name="updateC">Зберегти</button>
	<a class="btn btn-secondary" href="contracts.php?details=<?= $contract->getNumber() ?>" role="button" >Назад</a> 
	</form> 
 		<?php }
 		catch(Exception $e)
 		{?><div  class="alert  alert-danger"  role="alert"><?=  $e->getMessage() ?>
</div>
<?php
 		}
	}else{
?><a class="btn btn-success <?php if(strcmp($_SESSION['username'],'marketing')==0) echo 'disabled' ?>" href="contracts.php?new" role="button">Новий договір</a><?php
 	}
 }
}
if (isset($_GET['delete']))
 {
 	try
 	{
 		$contract = @$service->getContractByNumber($_GET['delete']);?>
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
        <p>Ви дійсно хочете видалити договір №<?=$contract->getNumber()?>?</p>
      </div>
      <div class="modal-footer">
      	<form action="contracts.php" method="post">
      		<input type="text" hidden name="number" value="<?=$contract->getNumber()?>">
        <button type="submit" class="btn btn-primary" name="deleteC">Видалити</button>
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
if(isset($_POST['saveC']))
 {
 	try{
 		@$service->createContract($_POST['number'],$_POST['agreed'],$_POST['supplier'],$_POST['title'],$_POST['note']);?>
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
 if(isset($_POST['deleteC']))
 {
 	try{
 		@$service->deleteContract($_POST['number']);?>
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
 if(isset($_POST['updateC']))
 {
 	try{
 		@$service->updateContract($_POST['number'],$_POST['agreed'],$_POST['supplier'],$_POST['title'],$_POST['note']);?>
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