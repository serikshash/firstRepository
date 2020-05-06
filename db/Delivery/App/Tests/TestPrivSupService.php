 <?php
require_once 
($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Repository/MySQLPrivSupRepository.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Delivery/App/Service/PrivSupService.php');
session_start();
$_SESSION['username'] = 'marketing';
$_SESSION['password'] = 'marketing';
class TestPrivSupService{
 	private $repository;
 	private $service;
 	public function __construct() {
 		$this->repository = new MySQLPrivSupRepository();
 		$this->service = new PrivSupService($this->repository);
 	}
 	public function shouldReturnPrivSupByID($id){
		try{
 			print_r($this->service->getPrivSupByID($id));
 		}
 		catch (Exception $e){
 			echo $e->getMessage();
 		}
 	}
 	
}
$test = new TestPrivSupService();
$test->shouldReturnPrivSupByID(1);
// $test->shouldReturnPrivSupByID(-1);
// $test->shouldReturnPrivSupByID(null);


?> 