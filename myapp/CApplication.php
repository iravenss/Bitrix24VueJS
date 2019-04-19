<?
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);


class CApplication
{
	public $arB24App;
	public $arAccessParams = array();
	public $arRatingUsers = array();
	public $currentUser = 0;
	private $b24_error = '';
	public $is_ajax_mode = false;
	public $currentRating = 0;
	public $userName = '';
	public $userFullName;
	public $resultCurUser = array();
	
	private function checkB24Auth() {
		
		
		$isTokenRefreshed = false;
		$this->arB24App = getBitrix24($this->arAccessParams, $isTokenRefreshed, $this->b24_error);
		return $this->b24_error === true;
	}
	
	private function returnJSONResult ($answer) {
		
		ob_start();
		ob_end_clean();
		Header('Cache-Control: no-cache');
		Header('Pragma: no-cache');
		echo json_encode($answer);
		die();
	}
	
	
	
	public function getCurUserID () {
		$obB24User = new \Bitrix24\Bitrix24User\Bitrix24User($this->arB24App);
		$arCurrentB24User = $obB24User->current();
		$this->currentUser = $arCurrentB24User["result"]["ID"];
		$this->userName = $arCurrentB24User["result"]["NAME"];
		$this->resultCurUser = $arCurrentB24User["result"];
		$this->userFullName = $arCurrentB24User["result"]["NAME"]." ".$arCurrentB24User["result"]["LAST_NAME"];
		return $this->currentUser;
		
	}
	
	
	
	public function getDomain () {
		return $this->arAccessParams['domain'];
	}
	
	public function getData () {
		
		$obB24User = new \Bitrix24\Bitrix24User\Bitrix24User($this->arB24App);
		$arCurrentB24User = $obB24User->current();
		$this->currentUser = $arCurrentB24User["result"]["ID"];
	
	}
	
	public function start ($requestArray) {
		
		$this->is_ajax_mode = isset($requestArray['action']);
		
		if (!$this->is_ajax_mode)
			$this->arAccessParams = prepareFromRequest($requestArray);
		else
			$this->arAccessParams = $requestArray;
		
		$this->b24_error = $this->checkB24Auth();
		
		if ($this->b24_error != '') {
			if ($this->is_ajax_mode)
				$this->returnJSONResult(array('status' => 'error', 'result' => $this->b24_error));
			else
				echo "B24 error: ".$this->b24_error;
			
			die;
		}
	}
	
	
	public function addUserToTable ($user_id,$portal,$name,$conn) {
		$result = $conn->query("SELECT * FROM `b24_users` WHERE `PORTAL` = '$portal' AND `ID_USER` = '$user_id'");
		if ($row = $result->fetch_assoc()) {
		
		} else {
			$result = $conn->query("INSERT INTO `b24_users` (`PORTAL`, `ID_USER`, `NAME`) VALUES ('$portal', '$user_id', '$name') ");
			if ($result) {
				return true;
			}
		
		}
	}
	public function getFullNameFromDB($user_id,$portal,$conn){
		$result = $conn->query("SELECT * FROM `b24_users` WHERE `PORTAL` = '$portal' AND `ID_USER` = '$user_id'");
		if ($row = $result->fetch_assoc()) {
			return $row['NAME'];
		}
	}
}


?>