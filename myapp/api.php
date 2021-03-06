<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
require_once __DIR__.'/vendor/autoload.php';
//require_once('bitrix24batch.php');
require_once("tools.php");
require_once("CApplication.php");

$application = new CApplication();
if (!empty($_REQUEST)) {
	 $application->start($_REQUEST);
	$domain = $application->getDomain();

}
$domain = $application->getDomain();
$user_id = $application->getCurUserID();
$user_name = $application->userName;
$user_fullname = $application->userFullName;


if (isset($_REQUEST['action'])) {
	
	
	$conn = new mysqli("localhost", "cf62548_bx24", "ByfSe9rH", "cf62548_bx24");
	if ($conn->connect_error) {
		die("Database connection established Failed..");
	}
	$res = array('error' => false);
	
	
	$action = 'read';
	
	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];
	}
	
	if ($action == 'read') {
		$result = $conn->query("SELECT * FROM `b24_points` WHERE `PORTAL` = '$domain'");
		$points = array();
		
		while ($row = $result->fetch_assoc()) {
			$row['USER'] = $application->getFullNameFromDB($row['ID_USER'],$domain,$conn);
			array_push($points, $row);
		}
		$res['points'] = $points;
		
	}
	
	if ($action == 'create') {
		
		$name    = $_POST['name'];
		$cords   = $_POST['cords'];
		$comment = $_POST['comment'];
		if($_POST['ID'] && $_POST['PLACEMENT'] ){
			switch ($_POST['PLACEMENT']) {
				case "":
					$contact_id = $_POST['ID'];
					
					break;
			}
			
		}
		//$domain = $_POST['domain'];
		
		$application->addUserToTable($user_id,$domain,$user_fullname,$conn);
		
		$result = $conn->query("INSERT INTO `b24_points` (`NAME`, `CORDS`, `ID_USER`, `COMMENT`, `PORTAL`, `CONTACT_ID` ) VALUES ('$name', '$cords','$user_id', '$comment','$domain','$contact_id') ");
		
		if ($result) {
			$res['message'] = "Точка успешно добавлена";
		} else {
			$res['error']   = true;
			$res['message'] = "Не получилось добавить точку";
			
		}
		
		
	}
	
	
	if ($action == 'update') {
		$id      = $_POST['ID'];
		$name    = $_POST['name'];
		$cords   = $_POST['cords'];
		$comment = $_POST['comment'];
		
		
		$result = $conn->query("UPDATE `b24_points` SET `name` = '$name', `cords` = '$cords', `comment` = '$comment' WHERE `id` = '$id'");
		if ($result) {
			$res['message'] = "Point Updated successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Point Update failed";
		}
	}
	
	
	if ($action == 'delete') {
		$id      = $_POST['ID'];
		$name    = $_POST['name'];
		$cords   = $_POST['cords'];
		$comment = $_POST['comment'];
		
		
		$result = $conn->query("DELETE FROM `b24_points` WHERE `id` = '$id' AND `PORTAL` = '$domain'");
		if ($result) {
			$res['message'] = "Point deleted successfully";
		} else {
			$res['error']   = true;
			$res['message'] = "Point delete failed";
		}
	}
	
	
	$conn->close();
	header("Content-type: application/json");
	echo json_encode($res);
	die();
}
//Установка
if ($_REQUEST['install'] == "Y") {
	
	$application->installHandlers($_REQUEST['handlers']);
	$res['FINISHED'] = "Y";
	$res['error'] = false;
	header("Content-type: application/json");
	echo json_encode($res);
	die();
	
}
 ?>