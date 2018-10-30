<?php

include("incs2.php");

if(isset($_REQUEST['call'])){
	$call = $_REQUEST['call'];
	switch ($call) {
		case "checkLoginStatus":
			onPageLoad();
			break;
		case "login":
			$email = $_REQUEST['email']; 
			$pass = $_REQUEST['pass']; 
			loginUser($email, $pass);
			break;
		case "signup":
			$email = $_REQUEST['email']; 
			$pass = $_REQUEST['pass']; 
			signupUser($email, $pass);
			break;
		case "checkAdminPass":
			$pass = $_REQUEST['pass']; 
			checkAdminPass($pass);
			break;
		case "divSignup":
			divSignup("Sign Up");
			break;
		case "divLogin":
			divLogin("Login");
			break;
		case "accountForm":
			divAccountForm();
			break;
		case "registerUser":
			$name = $_REQUEST['name']; $surname = $_REQUEST['surname']; $phone = $_REQUEST['phone']; 
			$city = $_REQUEST['city']; $sex = $_REQUEST['sex']; $dob = $_REQUEST['dob']; $address = $_REQUEST['address'];
			registerUser($name, $surname, $phone, $city, $sex, $dob, $address);
			break;
		case "registerForm":
			$type = $_REQUEST['type']; $name = $_REQUEST['name']; 
			$phone = $_REQUEST['phone']; $address = $_REQUEST['address']; $email = $_REQUEST['email'];
			registerForm($type, $name, $phone, $address, $email);
			break;
		case 'deleteRecord':
			$id = $_REQUEST['id']; $tableName = $_REQUEST['tableName'];
			deleteRecord($id, $tableName);
			break;
		case 'updateRecord':
			$id = $_REQUEST['id']; $tableName = $_REQUEST['tableName']; $name = $_REQUEST['name']; 
			$contact = $_REQUEST['contact']; $address = $_REQUEST['address']; $email = $_REQUEST['email'];
			updateRecord($id, $tableName, $name, $email, $contact, $address);
			break;
		case 'divRecordUpadte':
			$id = $_REQUEST['id']; $tableName = $_REQUEST['tableName']; $name = $_REQUEST['name']; 
			$contact = $_REQUEST['contact']; $address = $_REQUEST['address']; $email = $_REQUEST['email'];
			divRecordUpadte($id, $tableName, $name, $email, $contact, $address);
			break;
		case 'getTableHospitals':
			$tableName = $_REQUEST['tableName'];
			getTableHospitals($tableName);
			break;
		case 'donationBooking':
			$hospId = $_REQUEST['hospId']; $time = $_REQUEST['time']; $date = $_REQUEST['date'];
			bookDonation($hospId, $time, $date);
			break;
		case 'logout':
			session_unset(); 
			session_destroy();
			onPageLoad();
			break;
		case 'donorAccount':
			storePageSession("donor");
			divDonorAccount();
			break;
		case 'labAccount':
			if (isGrantedAccess("labs")) {
				storePageSession("lab");
				divLabAccount();
			} else {
				divChooseAccount("Error: Laboratory Access Denied");
			}
		case 'hositalAccount':
			if (isGrantedAccess("hospitals")) {
				storePageSession("hospital");
				divHospital();
			} else {
				divChooseAccount("Error: Hospital Access Denied");
			}
			break;
		case 'requesterAccount':
			storePageSession("requester");
			divRequesterAccount();
			break;
		case 'tableDonorBookings':
			$tableName = $_REQUEST['tableName']; $userId = $_REQUEST['userId'];
			getTableDonorBookings($tableName, $userId);
			break;
		case 'getTablehospitalBookings':
			getTablehospitalBookings();
			break;
		case 'getDonorBookingForm':
			divDonorBookingForm(); 
			break;
		case 'getTableDonorProfile':
			$tableName = $_REQUEST['tableName']; $userId = $_REQUEST['userId'];
			getTableDonorProfile($tableName, $userId);
			break;
		case 'getTablehospitalBookings':
			getTablehospitalBookings();
			break;
		case 'acceptBooking':
			$id = $_REQUEST['id']; $tableName = $_REQUEST['tableName'];
			acceptBooking($id, $tableName);
			break;
		case 'divLabTestForm':
			divLabTestForm();
			break;
		case 'orderBloodForm':
			orderBloodForm();
			break;
		case 'labTestSubmit':
			$labId = $_REQUEST['labId']; $donorEmail = $_REQUEST['donorEmail']; $donationNumber = $_REQUEST['donNum']; 
			labTestSubmit($labId, $donorEmail, $donationNumber);
			break;
		case 'getTablelabTests':
			getTablelabTests();
			break;
		case 'getPendingTestsTable':
			getPendingTestsTable();
			break;
		case 'getTestedLabTable':
			getTestedLabTable();
			break;
		case 'getTableHospitalOrders':
			getTableHospitalOrders();
			break;
		case 'getFlaggedLabTable':
			getFlaggedLabTable();
			break;

		case 'getTestedLabTableUser':
			getTestedLabTableUser();
			break;
		case 'getFlaggedLabTableUser':
			getFlaggedLabTableUser();
			break;

		case 'labTestUpdateForm':
			$id = $_REQUEST['id'];
			labTestUpdateForm($id);
			break;
		case 'getBloodLevels':
			getBloodLevels();
			break;
		case 'searchForBlood':
			$hospId = $_REQUEST['hospId']; $bloodId = $_REQUEST['bloodId']; $units = $_REQUEST['units'];
			searchForBlood($hospId, $bloodId, $units);
			break;
		case 'orderBloodUnit':
			$hospId = $_REQUEST['hospId']; $bloodId = $_REQUEST['bloodId']; $units = $_REQUEST['units'];
			orderBloodUnit($hospId, $bloodId, $units);
			break;
		case 'updateLabTestRecord':
		$id = $_REQUEST['id']; $bloodId = $_REQUEST['bloodId']; $bloodStatus = $_REQUEST['bloodStatus'];
			updateLabTestRecord($id, $bloodId, $bloodStatus);
			break;
		default:
			divForms($call);
			break;
	}
}

function onPageLoad(){
	if (!isset($_SESSION['page'])) {
		if(!isset($_SESSION['login'])) {
			divLogin("Blood Bank Project");
		} else if (!isRegistered()) {
			divRegister("User Registration");
		} else {
			divChooseAccount("Account Type");
		}
	} else {
		switch ($_SESSION['page']) {
			case 'admin':
				divAdmin();
				break;
			case 'donor':
				divDonorAccount();
				break;
			case 'hospital':
				divHospital();
				break;
			case 'requester':
				divRequesterAccount();
				break;
			case 'lab':
				divLabAccount();
				break;
		}
	}
}

function checkAdminPass($pass) {
	if ($pass === "AdmiN") {
		storePageSession("admin");
		divAdmin();
	} else {
		divChooseAccount("Error: Admin Access Denied");
	}
}

function isGrantedAccess($tableName) {
	$email = $_SESSION['email'];
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM $tableName WHERE email = '$email'");
	if (mysqli_num_rows($result) == 1) {
		return true;
	} else {
		return false;
	}
}

function isRegistered() {
	$email = $_SESSION['email'];
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM logged_users WHERE email = '$email'");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$row = mysqli_query($conn, "SELECT id FROM users WHERE user_id = '$id'");
		if (mysqli_num_rows($row) == 1) {
			return true;
		} else {
			return false;
		}
	}
}


function logoutUser() {
	session_unset(); 
	session_destroy();
	header("location:index.php"); exit;
}



function alertUser($message) {
	?>
	<script type="text/javascript">
		alert('<?php echo $message; ?>');
	</script>
	<?php
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}





function acceptBooking($id, $tableName) {
	$_SESSION['selectedTab'] = $tableName;
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	@mysqli_query($conn, "UPDATE $tableName SET status = 'yes' WHERE id = '$id' ")or die("error on query2");
	if(mysqli_affected_rows($conn) == 1){
		onPageLoad();
	}
}

function deleteRecord($id, $tableName) {
	$_SESSION['selectedTab'] = $tableName;
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	@mysqli_query($conn, "DELETE FROM $tableName WHERE id = '$id' ")or die("error on query2");
	if(mysqli_affected_rows($conn) == 1){
		onPageLoad();
	}
}

function updateRecord($id, $tableName, $name, $email, $contact, $address) {
	$_SESSION['selectedTab'] = $tableName;
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	@mysqli_query($conn, "UPDATE $tableName SET name = '$name', email = '$email', contact = '$contact', address = '$address'
								WHERE id = '$id' ")or die("error on query2");
	if(mysqli_affected_rows($conn) == 1){
		onPageLoad();
	}
}

function updateLabTestRecord($id, $bloodId, $bloodStatus) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	@mysqli_query($conn, "UPDATE lab_test SET blood_id = '$bloodId', status = '$bloodStatus'
								WHERE id = '$id' ")or die("error on query2");
	if(mysqli_affected_rows($conn) == 1){
		getPendingTestsTable();
	}
}

function labTestSubmit($labId, $donorEmail, $donationNumber) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME')) or die("Err");
	$userId = getUserUidEmail($donorEmail);
	$hospId = getEntityUid("hospitals");
	@mysqli_query($conn, "INSERT INTO lab_test(user_id, hospital_id, lab_id, donation_number, status) 
			VALUES('$userId', '$hospId', '$labId', '$donationNumber', '') ")or die("sql error");
	$id = mysqli_insert_id($conn);
	if($id != 0){
		divHospital();
	}
}






function registerForm($type, $name, $phone, $address, $email) {
	$tableName = "";
	if ($type == "divFormHospital") {
		$tableName = "hospitals";
	} elseif ($type == "divFormLabs") {
		$tableName = "labs";
	} elseif ($type == "divFormBloodBank") {
		$tableName = "blood_bank";
	}

	$_SESSION['selectedTab'] = $tableName;
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	mysqli_query($conn, "INSERT INTO $tableName(name, email, contact, address)  
		VALUES('$name', '$email', '$phone', '$address') ")or die("sql error");
	$id = mysqli_insert_id($conn);
	if($id != 0){
		onPageLoad();
	}
}

function bookDonation($hospId, $time, $date) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME')) or die("Err");
	$userId = getUserUid();
	@mysqli_query($conn, "INSERT INTO booking(user_id, hospital_id, x_time, x_date, status) 
			VALUES('$userId', '$hospId', '$time', '$date', 'no') ")or die("sql error");
	$id = mysqli_insert_id($conn);
	if($id != 0){
		divDonorAccount();
	}

}







function getNumbers($id, $tableName) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT $id FROM $tableName");
	return mysqli_num_rows($row); 
}

function getNumbersWhere($id, $tableName, $userId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT $id FROM $tableName WHERE user_id = '$userId' ");
	return mysqli_num_rows($row); 
}

function getNumbersField($tableName, $field, $userId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM $tableName WHERE $field = '$userId' ");
	return mysqli_num_rows($row); 
}

function getPendingLabTests($labId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND status = '' ");
	return mysqli_num_rows($row); 
}

function getTestedLabTests($labId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND (status = 'yes' OR status = 'ordered') ");
	return mysqli_num_rows($row); 
}

function getTestedLabTestsUser($userId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE user_id = '$userId' AND (status = 'yes' OR status = 'ordered') ");
	return mysqli_num_rows($row); 
}

function getFlaggedLabTests($labId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND status = 'no' ");
	return mysqli_num_rows($row); 
}

function getFlaggedLabTestsUser($userId) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE user_id = '$userId' AND status = 'no' ");
	return mysqli_num_rows($row); 
}

function searchForBlood($hospId, $bloodId, $units) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE hospital_id = '$hospId' AND status = 'yes' AND  blood_id = '$bloodId' ");
	
	if (mysqli_num_rows($row) != 0) {
		echo "Found " . mysqli_num_rows($row) . " Units of blood type " .  getHospitalName("blood_group", $bloodId);
	} else {
		echo "No results found!!";
	}
}

function orderBloodUnit($hospId, $bloodId, $units) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$row = mysqli_query($conn, "SELECT * FROM lab_test WHERE hospital_id = '$hospId' AND status = 'yes' AND  blood_id = '$bloodId' ");
	
	$orders = "ko";
	if (mysqli_num_rows($row) != 0) {
		for ($i = 0; $i < $units; $i++) {
			$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE hospital_id = '$hospId' AND status = 'yes' AND  blood_id = '$bloodId' LIMIT 1 ");
			while ($row = mysqli_fetch_array($result)) {
				$labTestId = $row['id']; $hospId = $row['hospital_id']; $bloodId = $row['blood_id'];

				mysqli_query($conn, "UPDATE lab_test SET status = 'ordered' WHERE id = '$labTestId' ")or die("error on query2");
				
				if(mysqli_affected_rows($conn) == 1){
					@mysqli_query($conn, "INSERT INTO blood_orders(lab_test_id, hospital_id, blood_id, status) 
											VALUES('$labTestId', '$hospId', '$bloodId', '') ")or die("sql error");
					$orders = "Ordered: " . "1 Unit of blood type " .  getHospitalName("blood_group", $bloodId) . "\n";
				}
			}
		}
	}
	echo $orders;
}






function getUserUid() {
	$email = $_SESSION['email'];
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM logged_users WHERE email = '$email' ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		return $id;
	}
}

function getUserUidEmail($email) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM logged_users WHERE email = '$email' ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		return $id;
	}
}

function getEntityUid($tableName) {
	$email = $_SESSION['email'];
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM $tableName WHERE email = '$email' ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		return $id;
	}
}






function getHospitals() {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id, name FROM hospitals ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id']; $name = $row['name'];
		?><option value="<?php echo $id; ?>"><?php echo $name; ?></option><?php
	}
}

function getBloodGroup() {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id, name FROM blood_group ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id']; $name = $row['name'];
		?><option value="<?php echo $id; ?>"><?php echo $name; ?></option><?php
	}
}

function getLabs() {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id, name FROM labs ");

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id']; $name = $row['name'];
		?><option value="<?php echo $id; ?>"><?php echo $name; ?></option><?php
	}
}





function getHospitalName($tableName, $id) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT name FROM $tableName WHERE id = '$id' ");

	while ($row = mysqli_fetch_array($result)) {
		$name = $row['name'];
	
		return $name;
	}
}

function getAddress($tableName, $email) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT address FROM $tableName WHERE email = '$email' ");

	while ($row = mysqli_fetch_array($result)) {
		$name = $row['address'];
	
		return $name;
	}
}

function getHospitalNameEmail($email) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT name FROM hospitals WHERE email = '$email' ");

	while ($row = mysqli_fetch_array($result)) {
		$name = $row['name'];
	
		return $name;
	}
}

function getUserNameSurname() {
	while ($row = mysqli_fetch_array(getUserDetails())) {
		$name = $row['name'];
		$surname = $row['surname'];
	
		return $name . " " . $surname;
	}
}

function getUserAddress() {
	while ($row = mysqli_fetch_array(getUserDetails())) {
		$address = $row['address'];

		return $address;
	}
}

function getUserNameSurnameId($id) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");

	while ($row = mysqli_fetch_array($result)) {
		$name = $row['name'];
		$surname = $row['surname'];
	
		return $name . " " . $surname;
	}
}

function getUserDetails(){
	$id = getUserUid();
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");

	return $result;
}






function storeLoginSession($email) {
	$_SESSION[$email] = $email;
}

function storeLoginEmail($email) {
	$_SESSION['email'] = $email;
}

function storePageSession($email) {
	$_SESSION['page'] = $email;
}






function divAdmin() {
	if (!isset($_SESSION['selectedTab'])) {
		$_SESSION['selectedTab'] = "hospitals";
	}
	?>
	<div id="adminDash" class="w3-display-container w3-theme-l5 full-height">
			<div id="sideBar" class="side-bar w3-display-left w3-card-4">
				<p class="w3-xlarge w3-center" style="font-family: serif;"><?php echo getUserNameSurname(); ?></p>
				<p class="w3-center w3-small"><?php echo $_SESSION['email']; ?></p>
				<hr style="height: 1px; margin-top: 25px; margin-left: 20px; margin-right: 20px;" class="w3-white">
				<hr style="height: 1px; margin-left: 20px; margin-right: 20px;" class="w3-white">
				<br />

				<div class="w3-btn w3-margin-top full-length w3-left w3-theme-d5" onclick="getTableHospitals('hospitals')">Hospitals</div>
				<div class=" w3-btn w3-margin-top full-length w3-left" onclick="getTableHospitals('labs')">Laboratories</div>
				<div class=" w3-btn w3-margin-top full-length w3-left" onclick="getTableHospitals('blood_bank')">Blood Banks</div>
				<!--<div class=" w3-btn w3-margin-top full-length w3-left" >Donors</div>
				<div class=" w3-btn w3-margin-top full-length w3-left">Requestors</div>
				<div class=" w3-btn w3-margin-top full-length w3-left">User Accounts</div>-->
				<div class=" w3-btn w3-margin-top full-length w3-left" onclick="tableDonorBookings('getBloodLevels', '')">Blood Levels</div>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
					<button name="logout" class=" w3-btn w3-margin-top full-length w3-left">Log out</button>	
				</form>
			</div>
			
			<div id="navBar" class="w3-bar nav-bar w3-border w3-light-grey w3-display-topright w3-card-4">
				<h2 class="w3-margin-left" style="color: gray;"><?php echo constant("DASH_NAME"); ?>
					<span class="w3-margin-left w3-small">Overview of Environment</span>
					<span class="w3-margin-left w3-right w3-margin-right w3-medium w3-theme-d5 w3-padding w3-round-large" style="color: gray;">Administrator</span>
				</h2>
			</div>

			<div id="topMenu" class="top-menu w3-display-topright">
				<div class="w3-row w3-margin-left">

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('divFormHospital')">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Hospitals</b></p>
								<p class="w3-small"><b><?php echo getNumbers("*", "hospitals"); ?></b></p>
							</div>
						</div>
					</div>

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('divFormLabs')">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Labs</b></p>
								<p class="w3-small"><b><?php echo getNumbers("id", "labs"); ?></b></p>
							</div>
						</div>
					</div>

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('divFormBloodBank')">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Blood Banks</b></p>
								<p class="w3-small"><b><?php echo getNumbers("*", "blood_bank"); ?></b></p>
							</div>
						</div>
					</div>

					<!--<div class="w3-col l2 w3-margin-top w3-margin-right">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Donors</b></p>
								<p class="w3-small"><b><?php //echo getNumbers("id", "donors"); ?></b></p>
							</div>
						</div>
					</div>

					<div class="w3-col l2 w3-margin-top w3-margin-right">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Requests</b></p>
								<p class="w3-small"><b><?php //echo getNumbers("id", "requests"); ?></b></p>
							</div>
						</div>
					</div>-->

					<!--<div class="menu button-add w3-green w3-center w3-display-right margin-top margin-right" style="margin-right: 100px;">+</div>-->

				</div>
			</div>
			
			<div id="main-panel" class="main-panel w3-display-topright w3-responsive">
				<div class="w3-responsive w3-margin">
					<table id="table" class="w3-table-all w3-hoverable w3-card-4 w3-round">
						<?php echo getTableHospitals($_SESSION['selectedTab']); ?>
					</table>
				</div>
			</div>
	</div>
	<?php
}

function divDonorAccount() {
	?>
	<div id="adminDash" class="w3-display-container w3-theme-l5 full-height">
		<div id="sideBar" class="side-bar w3-display-left w3-card-4">
			<div class="w3-card-4 w3-padding">
				<p class="w3-xlarge w3-center" style="font-family: serif;"><?php echo getUserNameSurname(); ?></p>
				<p class="w3-center w3-small"><?php echo $_SESSION['email']; ?></p>
				<hr style="height: 1px; margin-top: 25px; margin-left: 20px; margin-right: 20px;" class="w3-white">
				<br />
			</div>

			<div class="w3-btn w3-margin-top full-length w3-left" onclick="getDonorBookingForm()">Booking</div><!--
			<div class=" w3-btn w3-margin-top full-length w3-left" onclick="getTableDonorProfile('donor_profile', '<?php //echo getUserUid(); ?>')">Donor Profile</div>-->
  			<div class=" w3-btn w3-margin-top full-length w3-left" onclick="tableDonorBookings('getBloodLevels', '')">Blood Levels</div><!--
	      	<div class=" w3-btn w3-margin-top full-length w3-left">Donors</div>
	      	<div class=" w3-btn w3-margin-top full-length w3-left">Requestors</div>
	      	<div class=" w3-btn w3-margin-top full-length w3-left">User Accounts</div>-->
	      	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	      	<button name="logout" class=" w3-btn w3-margin-top full-length w3-left">Log out</button>	
	      	</form>
			</div>

	  	<div id="navBar" class="w3-bar nav-bar w3-border w3-light-grey w3-display-topright w3-card-4">
	  		<h2 class="w3-margin-left" style="color: gray;"><?php echo constant("DASH_NAME"); ?>
	  		<span class="w3-margin-left w3-small"><?php echo getUserAddress(); ?></span>
	  		<span class="w3-margin-left w3-right w3-margin-right w3-medium w3-theme-d5 w3-padding w3-round-large" style="color: gray;">Donor</span>
	  		</h2>
		</div>

		<div id="topMenu" class="top-menu w3-display-topright">
			<div class="w3-row w3-margin-left">

				<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('getTestedLabTableUser', '')">
					<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
						<div class="w3-container">
							<p class="w3-xlarge"><b>Donations</b></p>
							<p class="w3-small"><b><?php echo getTestedLabTestsUser(getUserUid()); ?></b></p>
						</div>
					</div>
				</div>

				<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('booking', '<?php echo getUserUid(); ?>')">
					<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
						<div class="w3-container">
							<p class="w3-xlarge"><b>Bookings</b></p>
							<p class="w3-small"><b><?php echo getNumbersWhere("id", "booking", getUserUid()); ?></b></p>
						</div>
					</div>
				</div>

				<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('getFlaggedLabTableUser', '')">
					<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
						<div class="w3-container">
							<p class="w3-xlarge"><b>Flagged</b></p>
							<p class="w3-small"><b><?php echo getFlaggedLabTestsUser(getUserUid()); ?></b></p>
						</div>
					</div>
				</div>

				<!--<div class="menu button-add w3-green w3-center w3-display-right margin-top margin-right" style="margin-right: 100px;">+</div>-->

			</div>
		</div>

		<div id="main-panel" class="main-panel w3-display-topright w3-responsive">
			<?php divDonorBookingForm(); ?>
		</div>
	</div>
	<?php
}

function divHospital() {
	if (!isset($_SESSION['selectedTab'])) {
	$_SESSION['selectedTab'] = "hospitals";
	}
	?>
	<div id="adminDash" class="w3-display-container w3-theme-l5 full-height">
	<div id="sideBar" class="side-bar w3-display-left w3-card-4">
		<p class="w3-xlarge w3-center" style="font-family: serif;"><?php echo getHospitalNameEmail($_SESSION['email']); ?></p>
		<p class="w3-center w3-small"><?php echo $_SESSION['email']; ?></p>
		<hr style="height: 1px; margin-top: 25px; margin-left: 20px; margin-right: 20px;" class="w3-white">
		<br />

		<div class="w3-btn w3-margin-top full-length w3-left" onclick="divForms('divLabTestForm')">Lab Testing</div>
		<div class=" w3-btn w3-margin-top full-length w3-left" onclick="divForms('orderBloodForm')">Order Blood</div>
		<div class=" w3-btn w3-margin-top full-length w3-left" onclick="divForms('getBloodLevels', '')">Blood Levels</div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<button name="logout" class=" w3-btn w3-margin-top full-length w3-left">Log out</button>	
		</form>
	</div>

	<div id="navBar" class="w3-bar nav-bar w3-border w3-light-grey w3-display-topright w3-card-4">
		<h2 class="w3-margin-left" style="color: gray;"><?php echo constant("DASH_NAME"); ?>
		<span class="w3-margin-left w3-small"><?php echo "Address: " . getAddress("hospitals", $_SESSION['email']); ?></span>
		<span class="w3-margin-left w3-right w3-margin-right w3-medium w3-theme-d5 w3-padding w3-round-large" style="color: gray;">Hospital</span>
	</h2>
	</div>

	<div id="topMenu" class="top-menu w3-display-topright">
		<div class="w3-row w3-margin-left">

			<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('getTablelabTests')">
				<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
					<div class="w3-container">
						<p class="w3-xlarge"><b>Lab Tests</b></p>
						<p class="w3-small"><b><?php echo getNumbersField("lab_test", "hospital_id", getEntityUid("hospitals")); ?></b></p>
					</div>
				</div>
			</div>

			<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('getTableHospitalOrders')">
				<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
					<div class="w3-container">
						<p class="w3-xlarge"><b>Orders</b></p>
						<p class="w3-small"><b><?php echo getNumbersField("blood_orders", "hospital_id", getEntityUid("hospitals")); ?></b></p>
					</div>
				</div>
			</div>

			<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('getTablehospitalBookings')">
				<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
					<div class="w3-container">
						<p class="w3-xlarge"><b>Bookings</b></p>
						<p class="w3-small"><b><?php echo getNumbers("*", "hospitals"); ?></b></p>
					</div>
				</div>
			</div>

			<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('getTablehospitalBookings')">
				<div class="menu w3-card-4 w3-round-large w3-hover-red w3-theme-d5 w3-center" style="">
					<div class="w3-container">
						<p class="w3-medium"><b>Send Low Stocks Notification Messages</b></p>
					
					</div>
				</div>
			</div>

			<!--<div class="menu button-add w3-green w3-center w3-display-right margin-top margin-right" style="margin-right: 100px;">+</div>-->

		</div>
		</div>

		<div id="table" class="main-panel w3-display-topright w3-responsive">
		<?php divLabTestForm(); ?>
		</div>
	</div>
	<?php
}

function divRequesterAccount() {
	?>
	<div id="adminDash" class="w3-display-container w3-theme-l5 full-height">
    <div id="sideBar" class="side-bar w3-display-left w3-card-4">
      <div class="w3-card-4 w3-padding">
      	<p class="w3-xlarge w3-center" style="font-family: serif;"><?php echo getHospitalNameEmail($_SESSION['email']); ?></p>
	    <p class="w3-center w3-small"><?php echo $_SESSION['email']; ?></p>
	    <hr style="height: 1px; margin-top: 25px; margin-left: 20px; margin-right: 20px;" class="w3-white">
	    <br />
      </div>

      <div class="w3-card w3-btn w3-margin-top full-length w3-left w3-theme-d5" onclick="getDonorBookingForm()">Blood Request</div>
      <div class="w3-card w3-btn w3-margin-top full-length w3-left w3-theme-d5" onclick="getDonorBookingForm()">Request Records</div><!--
      <div class=" w3-btn w3-margin-top full-length w3-left">Donors</div>
      <div class=" w3-btn w3-margin-top full-length w3-left">Requestors</div>
      <div class=" w3-btn w3-margin-top full-length w3-left">User Accounts</div>-->
      <div class=" w3-btn w3-margin-top full-length w3-left" onclick="logout()">Log out</div>
    </div>
      
    <div id="navBar" class="w3-bar nav-bar w3-border w3-light-grey w3-display-topright w3-card-4">
      <h2 class="w3-margin-left" style="color: gray;">DASHBOARD
        <span class="w3-margin-left w3-small"><?php echo "Address: " . getAddress("hospitals", $_SESSION['email']); ?></span>
        <span class="w3-margin-left w3-right w3-margin-right w3-medium w3-theme-d5 w3-padding w3-round-large" style="color: gray;">Requester</span>
      </h2>
    </div>

    <div id="topMenu" class="top-menu w3-display-topright">
      <div class="w3-row w3-margin-left">

        <div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('divFormHospital')">
          <div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
            <div class="w3-container">
              <p class="w3-xlarge"><b>Pending</b></p>
              <p class="w3-small"><b><?php echo getNumbers("*", "hospitals"); ?></b></p>
            </div>
          </div>
        </div>

        <div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('booking', '<?php echo getUserUid(); ?>')">
          <div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
            <div class="w3-container">
              <p class="w3-xlarge"><b>Approved</b></p>
              <p class="w3-small"><b><?php echo getNumbersWhere("id", "booking", getUserUid()); ?></b></p>
            </div>
          </div>
        </div>

        <div class="w3-col l2 w3-margin-top w3-margin-right" onclick="divForms('divFormBloodBank')">
          <div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
            <div class="w3-container">
              <p class="w3-xlarge"><b>Denied</b></p>
              <p class="w3-small"><b><?php echo getNumbers("*", "blood_bank"); ?></b></p>
            </div>
          </div>
        </div>

        <!--<div class="menu button-add w3-green w3-center w3-display-right margin-top margin-right" style="margin-right: 100px;">+</div>-->

      </div>
    </div>
  
    <div id="main-panel" class="main-panel w3-display-topright w3-responsive">
      <?php divDonorBookingForm(); ?>
    </div>
  	</div>
	<?php
}

function divLabAccount() {
	?>
	<div id="adminDash" class="w3-display-container w3-theme-l5 full-height">
			<div id="sideBar" class="side-bar w3-display-left">
				<div class="w3-padding">
					<p class="w3-xlarge w3-center" style="font-family: serif;"><?php echo getHospitalName("labs", getEntityUid("labs")); ?></p>
					<p class="w3-center w3-small"><?php echo $_SESSION['email']; ?></p>
					<hr style="height: 1px; margin-top: 25px; margin-left: 20px; margin-right: 20px;" class="w3-white">
					<br />
				</div>

				<!--<div class="w3-btn w3-margin-top full-length w3-left" onclick="getDonorBookingForm()">Test Results</div>
	      		<div class="w3-btn w3-margin-top full-length w3-left" onclick="getDonorBookingForm()">Test Records</div>
	      		<div class=" w3-btn w3-margin-top full-length w3-left">Donors</div>
	      		<div class=" w3-btn w3-margin-top full-length w3-left">Requestors</div>
	      		<div class=" w3-btn w3-margin-top full-length w3-left">User Accounts</div>-->
	      		<div class=" w3-btn w3-margin-top full-length w3-left" onclick="tableDonorBookings('getBloodLevels', '')">Blood Levels</div>
	      		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	      			<button name="logout" class=" w3-btn w3-margin-top full-length w3-left">Log out</button>	
	      		</form>
	  		</div>

			  <div id="navBar" class="w3-bar nav-bar w3-border w3-light-grey w3-display-topright w3-card-4">
			  	<h2 class="w3-margin-left" style="color: gray;"><?php echo constant("DASH_NAME"); ?>
			  	<span class="w3-margin-left w3-small"><?php echo "Address: " . getAddress("hospitals", $_SESSION['email']); ?></span>
			  	<span class="w3-margin-left w3-right w3-margin-right w3-medium w3-theme-d5 w3-padding w3-round-large" style="color: gray;">Laboratory</span>
			  </h2>
			</div>

			<div id="topMenu" class="top-menu w3-display-topright">
				<div class="w3-row w3-margin-left">

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('getPendingTestsTable', '')"><!--divForms('getPendingTestsTable')-->
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Pending</b></p>
								<p class="w3-small"><b><?php echo getPendingLabTests(getEntityUid("labs")); ?></b></p>
							</div>
						</div>
					</div>

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('getTestedLabTable', '')">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Tested</b></p>
								<p class="w3-small"><b><?php echo getTestedLabTests(getEntityUid("labs")); ?></b></p>
							</div>
						</div>
					</div>

					<div class="w3-col l2 w3-margin-top w3-margin-right" onclick="tableDonorBookings('getFlaggedLabTable', '')">
						<div class="menu w3-card-4 w3-round-large w3-hover-red w3-center" style="">
							<div class="w3-container">
								<p class="w3-xlarge"><b>Flagged</b></p>
								<p class="w3-small"><b><?php echo getFlaggedLabTests(getEntityUid("labs")); ?></b></p>
							</div>
						</div>
					</div>

					<!--<div class="menu button-add w3-green w3-center w3-display-right margin-top margin-right" style="margin-right: 100px;">+</div>-->

				</div>
			</div>

			<div id="main-panel" class="main-panel w3-display-topright w3-responsive">
				<div id="labdiv"></div>
		
			</div>
		</div>
	<?php
}

function divChooseAccount($name) {
	?>
	<div id="chooseAccount" class="w3-display-container w3-theme-l5 full-height">
		<form id="accountForm" class="w3-display-topright half-width w3-margin">
	        
    	</form>
    <div class="w3-display-middle full-width">
      <h2 class="align-center w3-xxlarge"><?php echo $name; ?></h2><br />

      	<div id="cursor" class="w3-row">
        	<div class="w3-col l2 w3-margin" onclick="donorAccount()">
          		<div class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
            		<i class="fa fa-gift" style="font-size: 56px;color:red;"></i>
            		<div class="w3-container">
              		<p class="w3-xlarge"><b>Donor</b></p>
            		</div>
          		</div>
        	</div>

        <div id="cursor" class="w3-col l2 w3-margin" onclick="hositalAccount()">
          <div class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
            <i class="fa fa-hospital-o" style="font-size: 56px;color:red;"></i>
            <div class="w3-container">
              <p class="w3-xlarge"><b>Hospital</b></p>
            </div>
          </div>
        </div>

        <div id="cursor" class="w3-col l2 w3-margin" onclick="laboratoryAccount()">
          <div class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
            <i class="fa fa-hospital-o" style="font-size: 56px;color:red;"></i>
            <div class="w3-container">
              <p class="w3-xlarge"><b>Laboratory</b></p>
            </div>
          </div>
        </div>

        <div id="cursor" class="w3-col l2 w3-margin" onclick="requesterAccount()">
          <div class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
            <i class="fa fa-question-circle-o" style="font-size: 56px;color:red;"></i>
            <div class="w3-container">
              <p class="w3-xlarge"><b>Requestor</b></p>
            </div>
          </div> 
        </div>

        <div id="cursor" class="w3-col l2 w3-margin" onclick="accountForm()">
          <div class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
            <i class="fa fa-gear fa-spin" style="font-size: 56px;color:red;"></i>
            <div class="w3-container">
              <p class="w3-xlarge"><b>Admin</b></p>
            </div>
          </div> 
        </div>
      </div>

    </div>
  </div>
	<?php
}






function getTableHospitals($tableName) {
	?>
	<div class="w3-responsive w3-margin">
	<table id="table" class="w3-table-all w3-hoverable w3-card-4 w3-round">
	<tr class="w3-green">
        <th>Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Address</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM $tableName");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id']; $name = $row['name']; $email = $row['email']; $contact = $row['contact']; $address = $row['address'];
		?>
		<tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $contact; ?></td>
            <td><?php echo $address; ?></td>
            <td><span onclick="divRecordUpadte('<?php echo $id ?>', '<?php echo $tableName; ?>', 
            '<?php echo $name; ?>', '<?php echo $email; ?>', '<?php echo $contact; ?>', '<?php echo $address; ?>')" 
            	class="menu w3-tag w3-green w3-round">Update</span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', '<?php echo $tableName; ?>')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr></table></div>
		<?php
	}
}

function getTablelabTests() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$hospId = getEntityUid("hospitals");

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE hospital_id = '$hospId' ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php echo $status; ?></b></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'lab_test')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getTableHospitalOrders() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Hospital</th>
        <th>Testing Lab</th>
        <th>Blood Group</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$hospId = getEntityUid("hospitals");

	$result = mysqli_query($conn, "SELECT * FROM blood_orders WHERE hospital_id = '$hospId' ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id']; $hospId = $row['hospital_id']; $labId = $row['lab_test_id']; 
		$bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php if ($status == "") { echo "Pending"; } else if ($status == "yes") { echo "Ordered"; } ?></b></td>
            <td><span onclick="acceptBooking('<?php echo $id; ?>', 'blood_orders')" 
            	class="menu w3-tag w3-green w3-round">Accept</span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'lab_test')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getPendingTestsTable() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$labId = getEntityUid("labs");

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND status = '' ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php echo $status; ?></b></td>
            <td><span onclick="labTestUpdateForm('<?php echo $id; ?>')" 
            	class="menu w3-tag w3-green w3-round">Update</span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'lab_test')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getTestedLabTable() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$labId = getEntityUid("labs");

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND (status = 'yes' OR status = 'ordered')");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php if ($status == "yes") { echo "Safe"; } else { echo $status; } ?></b></td>
            <td><span onclick="labTestUpdateForm('<?php echo $id; ?>')" 
            	class="menu w3-tag w3-green w3-round"><?php if ($status != "ordered") { echo "Update"; } ?></span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'lab_test')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getFlaggedLabTable() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$labId = getEntityUid("labs");

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE lab_id = '$labId' AND status = 'no' ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php echo "Unsafe"; ?></b></td>
            <td><span onclick="labTestUpdateForm('<?php echo $id; ?>')" 
            	class="menu w3-tag w3-green w3-round">Update</span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'lab_test')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getTestedLabTableUser() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$userId = getUserUid();

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE user_id = '$userId' AND (status = 'yes' OR status = 'ordered') ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php echo "Safe" ?></b></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getFlaggedLabTableUser() {
	?>
	<div class="w3-responsive w3-margin w3-round w3-padding">
	<table id="table" class="w3-table-all w3-hoverable w3-round">
	<tr class="w3-green">
        <th>Donor</th>
        <th>Hospital</th>
        <th>Lab</th>
        <th>Num</th>
        <th>B-Type</th>
        <th>Status</th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$userId = getUserUid();

	$result = mysqli_query($conn, "SELECT * FROM lab_test WHERE user_id = '$userId' AND status = 'no' ");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$userId = $row['user_id']; $hospId = $row['hospital_id']; $labId = $row['lab_id']; 
		$donationNumber = $row['donation_number']; $bloodId = $row['blood_id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo getUserNameSurnameId($userId); ?></td>
            <td><?php echo getHospitalName("hospitals", $hospId) ?></td>
            <td><?php echo getHospitalName("labs", $labId) ?></td>
            <td><?php echo $donationNumber; ?></td>
            <td><?php echo getHospitalName("blood_group", $bloodId) ?></td>
            <td><b><?php echo "Unsafe";  ?></b></td>
         </tr>
		<?php
	}
	?></table></div><?php
}

function getBloodLevels() {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM blood_group ");
	$resultAll = mysqli_query($conn, "SELECT * FROM lab_test ");
	$total = mysqli_num_rows($resultAll);

	?>
	<div class="w3-row w3-margin w3-padding w3-margin">
		<?php 
		while ($row = mysqli_fetch_array($result)) {
			$id = $row['id']; $name = $row['name'];
			$resultGroup = mysqli_query($conn, "SELECT * FROM lab_test WHERE blood_id = '$id' ");
			$totalGroup = mysqli_num_rows($resultGroup);

			$percent = ($totalGroup / $total) * 100;
			$color = "";
			if ($percent < 30) { $color = "w3-red"; }
			else if ($percent < 50) { $color = "w3-yellow"; }
			else if ($percent < 60) { $color = "w3-blue"; }
			else { $color = "w3-green"; }
 			?>
        	<div class="w3-col l7 w3-light-grey w3-round-xxlarge w3-medium">
	          	<div class="w3-medium w3-padding-right w3-container <?php echo $color; ?> w3-round-xxlarge" 
	          		style="width: <?php echo $percent . "%"; ?>"><b><?php echo $name; ?>&nbsp;</b></div>
        	</div>
        	<h4 class="w3-col l5 w3-medium"><b><?php echo $percent . "%" ."    ". "(" . $totalGroup ." ". "of" ." ". $total . ")"; ?></b></h4><?php
        }?>
	</div>
	<?php
}




function getTableDonorBookings($tableName, $userId) {
	?>
	<div class="w3-responsive w3-margin">
    <table id="table" class="w3-table-all w3-hoverable w3-card-4 w3-round">
	<tr class="w3-green">
        <th>Hospital</th>
        <th>Time</th>
        <th>Date</th>
        <th>Status</th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM $tableName WHERE user_id = '$userId' ");
	while ($row = mysqli_fetch_array($result)) {
		$name = getHospitalName("hospitals", $row['hospital_id']); $time = $row['x_time']; $date = $row['x_date'];
		$id = $row['id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $time; ?></td>
            <td><?php echo $date; ?></td>
        	<th><?php if ($status == "no") { echo "Pending"; } else { echo "Booked"; } ?></th>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', '<?php echo $tableName; ?>')" 
            	class="menu w3-tag w3-red w3-round">Delete</span></td>
         </tr>
		<?php
	}
	?>
	</table>
	</div><?php
}

function getTablehospitalBookings() {
	?>
	<div class="w3-responsive w3-margin">
    <table id="table" class="w3-table-all w3-hoverable w3-card-4 w3-round">
	<tr class="w3-green">
		<th>Name</th>
        <th>Hospital</th>
        <th>Time</th>
        <th>Date</th>
        <th>Status</th>
        <th></th>
        <th></th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$userId = getEntityUid("hospitals");
	$result = mysqli_query($conn, "SELECT * FROM booking WHERE hospital_id = '$userId' ");
	while ($row = mysqli_fetch_array($result)) {
		$userName = getUserNameSurnameId($row['user_id']);
		$name = getHospitalName("hospitals", $row['hospital_id']); $time = $row['x_time']; $date = $row['x_date'];
		$id = $row['id']; $status = $row['status'];
		?>
		<tr>
            <td><?php echo $userName; ?></td>
            <td><?php echo $name; ?></td>
            <td><?php echo $time; ?></td>
            <td><?php echo $date; ?></td>
        	<th><?php if ($status == "no") { echo "Pending"; } else { echo "Booked"; } ?></th>
            <td><span onclick="acceptBooking('<?php echo $id; ?>', 'booking')" 
            	class="menu w3-tag w3-green w3-round">Accept</span></td>
            <td><span onclick="deleteRecord('<?php echo $id; ?>', 'booking')" 
            	class="menu w3-tag w3-red w3-round">Reject</span></td>
         </tr>
		<?php
	}
	?>
	</table>
	</div><?php
}

function getTableDonorProfile($tableName, $userId) {
	?>
	<div class="w3-responsive w3-margin">
    <table id="table" class="w3-table-all w3-hoverable w3-card-4 w3-round">
	<tr class="w3-green">
        <th>Blood Group</th>
        <th>Hospital</th>
        <th>Blood Bank</th>
        <th>Laboratory</th>
    </tr>
	<?php
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT * FROM $tableName WHERE user_id = '$userId' ");
	while ($row = mysqli_fetch_array($result)) {
		$hospitalName = getHospitalName("hospitals", $row['hospital_id']); $bloodGroupName = getHospitalName("blood_group", $row['blood_group_id']);
		$bloodBankName = getHospitalName("blood_bank", $row['blood_bank_id']); $labName = getHospitalName("labs", $row['lab_id']);
		?>
		<tr>
            <td><?php echo $bloodGroupName; ?></td>
            <td><?php echo $hospitalName; ?></td>
            <td><?php echo $bloodBankName; ?></td>
            <td><?php echo $labName; ?></td>
         </tr>
		<?php
	}
	?>
	</table>
	</div><?php
}




function divDonorBookingForm() {
	?>
	<div class="w3-responsive w3-margin">
        <div class="w3-display-topleft half-width">
	      <form class="w3-container">
	        <h3 class="align-center w3-xxlarge"></h3>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <select id="book_hosp" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Select Hospital</option>
			  <?php getHospitals(); ?>
			</select></p>

	        <p>
	        <input id="book_time" class="w3-input w3-border w3-round" name="name" type="time" placeholder="Time" required></p>

	        <p>
	        <input id="book_date" class="w3-input w3-border w3-round" name="first" type="date" placeholder="Date" required></p>

	        <p>
	        <label>&nbsp;</label><br /><br />
	        <button onclick="donorBooking()" 
	        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="BOOK">BOOK</button></p>
	      </form>
    	</div>
      </div>
	<?php
}

function labTestUpdateForm($id) {
	?>
	<div class="w3-responsive w3-margin">
        <div class="w3-display-topleft half-width">
	      <form class="w3-container">
	        <h3 class="align-center w3-xxlarge"></h3>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <select id="lab_test_blood_type" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Blood Type</option>
			  <?php getBloodGroup(); ?>
			</select></p>

	        <p>
	        <select id="lab_test_blood_status" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Blood Status</option>
			  <option value="yes">Safe</option>
			  <option value="no">Unsafe</option>
			</select></p>

	        <p>
	        <label>&nbsp;</label><br /><br />
	        <button onclick="updateLabTestRecord('<?php echo $id ?>')" 
	        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="BOOK">UPDATE</button></p>
	      </form>
    	</div>
      </div>
	<?php
}

function divLabTestForm() {
	?>
	<div class="w3-responsive w3-margin">
        <div class="w3-display-topleft half-width">
	      <form class="w3-container">
	        <h3 class="align-center w3-xxlarge"></h3>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <select id="lab_id" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Select Laboratory</option>
			  <?php getLabs(); ?>
			</select></p>

	        <p>
	        <input id="lab_don_email" class="w3-input w3-border w3-round" name="email" type="email" placeholder="Donor Email" required></p>

	        <p>
	        <input id="lab_don_num" class="w3-input w3-border w3-round" name="donor" type="text" placeholder="Donation Number" required></p>

	        <p>
	        <label>&nbsp;</label><br /><br />
	        <button onclick="labTestSubmit()" 
	        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="BOOK">Send for Lab Testing</button></p>
	      </form>
    	</div>
      </div>
	<?php
}

function orderBloodForm() {
	?>
	<div class="w3-responsive w3-margin">
        <div class="w3-display-topleft half-width">
	      <form class="w3-container">
	        <h3 class="align-center w3-xxlarge"></h3>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <select id="hosp_id" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Select Hospital</option>
			  <?php getHospitals(); ?>
			</select></p>

			<p>
	        <select id="blood_id" class="full-width w3-padding w3-border w3-round">
			  <option value="0">Select Blood Group</option>
			  <?php getBloodGroup(); ?>
			</select></p>

	        <p>
	        <input id="blood_units" class="w3-input w3-border w3-round" name="units" type="number" placeholder="Units" required></p>

			<h4 class="w3-large"><b id="bloodSearch">Results: </b></h4>
	        
	        <p>
	        <label>&nbsp;</label><br /><br />
	        <button onclick="searchForBlood('searchForBlood')" 
	        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="BOOK">Search</button></p>

	        <p>
	        <button onclick="searchForBlood('orderBloodUnit')" 
	        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="BOOK">Order</button></p>
	      </form>
    	</div>
      </div>
	<?php
}





function divAccountForm() {
	?>
	<input id="admin_password" class="w3-input w3-border w3-round" name="password" type="password" placeholder="Admin Password" required></p>
    <p>
    <input id="submit" type="submit" class="w3-btn half-height w3-card w3-theme-d4 w3-round w3-right" value="SUBMIT"></p>
	<?php
}

function divSignup($message) {
	?>
	<div id="signup" class="w3-display-container w3-theme-d5 full-height">
	    <div class="w3-display-middle half-height">
	      <form class="w3-container">
	        <h2 class="align-center w3-xxlarge"><?php echo $message; ?></h2>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <input id="sign_email" class="w3-input w3-border w3-round" name="first" type="email" placeholder="Email address" required></p>
	        <p>
	        <label>&nbsp;</label>
	        <input id="sign_password" class="w3-input w3-border w3-round" name="last" type="password" placeholder="Password" required></p>
	        <p>
	        <label>&nbsp;</label><br /><br />
	        <input type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" 
	        onclick="signup()" value="SIGN UP">
	        <input type="button" onclick="divLogin()" class="w3-btn" value="LOGIN" style="width: 300px;"></p>
	      </form>
	    </div>
	</div>
	<?php
}

function divLogin($message) {
	?>
	<div id="login" class="w3-display-container w3-theme-d5 full-height">
	    <div class="w3-display-middle half-height">
	      <form id="form_login" class="w3-container" method="POST">
	        <h2 class="align-center w3-xxlarge"><?php echo $message; ?></h2>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <input id="log_email" class="w3-input w3-border w3-round" name="first" type="email" placeholder="Email address" required></p>
	        <p>
	        <label>&nbsp;</label>
	        <input id="log_password" class="w3-input w3-border w3-round" name="last" type="password" placeholder="Password" required></p>
	        <p>
	        <label>&nbsp;</label><br /><br />
	        <input id="submit" type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" 
	        onclick="login()" value="LOGIN">
	        <input type="button" onclick="divSignup()" class="w3-btn" value="SIGN UP" style="width: 300px;"></p>
	      </form>
	    </div>
	</div>
	<?php
}

function divRegister($message) {
	?>
	<div id="registration" class="w3-display-container w3-theme-d5 full-height">
    <div class="w3-display-middle half-width">
      <form class="w3-container">
        <h3 class="align-center w3-xxlarge">User Registration</h3>
        <p>&nbsp;</p>
        <p>
        <label>&nbsp;</label>
        <input id="reg_name" class="w3-input w3-border w3-round" name="name" type="text" placeholder="Name" required></p>
        
        <p>
        <input id="reg_surname" class="w3-input w3-border w3-round" name="surname" type="text" placeholder="Surname" required></p>

        <p>
        <input id="reg_phone" class="w3-input w3-border w3-round" name="first" type="number" placeholder="Phone Number" required></p>
        
        <p>
        <input id="reg_city" class="w3-input w3-border w3-round" name="city" type="text" placeholder="City" required></p>
        
        <p>
        <input id="reg_sex" class="w3-input w3-border w3-round" name="city" type="text" placeholder="Sex" required></p>

        <p>
        <input id="reg_dob" 
        class="w3-input w3-border w3-round" name="first" type="number" placeholder="Date of Birth ie 27-06-1990" required></p>

        <p>
        <input id="reg_address" class="w3-input w3-border w3-round" name="address" type="text" placeholder="Home Address" required></p>

        <p>
        <label>&nbsp;</label><br /><br />
        <input onclick="registerUser()" type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="DONE">
      </form>
    </div>
  </div>
	<?php
}

function divForms($message) {
	$name = "";
	if ($message == "divFormHospital") {
		$name = "Add a Hospital";
	} elseif ($message == "divFormLabs") {
		$name = "Add a Laboratory";
	} elseif ($message == "divFormBloodBank") {
		$name = "Add a Blood Bank";
	}

	?>
	<div id="registration" class="w3-display-container w3-theme-d5 full-height">
    <div class="w3-display-middle half-width">
      <form class="w3-container">
        <h3 class="align-center w3-xxlarge"><?php echo $name; ?></h3>
        <p>&nbsp;</p>
        <p>
        <label>&nbsp;</label>
        <input id="form_name" class="w3-input w3-border w3-round" name="name" type="text" placeholder="Name" required></p>

        <p>
        <input id="form_email" class="w3-input w3-border w3-round" name="name" type="email" placeholder="Email" required></p>

        <p>
        <input id="form_phone" class="w3-input w3-border w3-round" name="first" type="number" placeholder="Phone Number" required></p>

        <p>
        <input id="form_address" class="w3-input w3-border w3-round" name="address" type="text" placeholder="Address" required></p>

        <p>
        <label>&nbsp;</label><br /><br />
        <input onclick="registerForm('<?php echo $message; ?>')" 
        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="DONE">
    	<input type="button" onclick="checkLoginStatus()" class="w3-btn" value="CANCEL" style="width: 300px;"></p>
      </form>
    </div>
  </div>
	<?php
}

function divRecordUpadte($id, $tableName, $name, $email, $contact, $address) {
	?>
	<div id="registration" class="w3-display-container w3-theme-d5 full-height">
    <div class="w3-display-middle half-width">
      <form class="w3-container">
        <h3 class="align-center w3-xxlarge">Update Record</h3>
        <p>&nbsp;</p>
        <p>
        <label>&nbsp;</label>
        <input id="form_name" class="w3-input w3-border w3-round" value="<?php echo $name; ?>" type="text" placeholder="Name" required></p>

       	<p>
        <input id="form_email" class="w3-input w3-border w3-round" value="<?php echo $email; ?>" type="email" 
        placeholder="Name" required></p>

        <p>
        <input id="form_phone" class="w3-input w3-border w3-round" value="<?php echo $contact; ?>" 
        type="number" placeholder="Phone Number" required></p>

        <p>
        <input id="form_address" class="w3-input w3-border w3-round" value="<?php echo $address; ?>" 
        type="text" placeholder="Address" required></p>

        <p>
        <label>&nbsp;</label><br /><br />
        <input onclick="updateRecord('<?php echo $id; ?>', '<?php echo $tableName; ?>')" 
        type="button" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="UPDATE">
    	<input type="button" onclick="checkLoginStatus()" class="w3-btn" value="CANCEL" style="width: 300px;"></p>
      </form>
    </div>
  </div>
	<?php
}
?>