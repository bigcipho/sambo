<?php

include("control_panel.php");

if (!isset($_SESSION['page'])) {
	if(!isset($_SESSION['login'])) {
		header("location:index.php"); exit;
	} else if (!isRegistered()) {
		header("location:signup.php"); exit;
	} else {
		header("location:account.php"); exit;
	}
} else {
	switch ($_SESSION['page']) {
		case 'admin':
		
		break;
		case 'donor':
		header("location:donor.php"); exit;
		break;
		case 'hospital':
		header("location:hospital.php"); exit;
		break;
		case 'requester':
		header("location:requestor.php"); exit;
		break;
		case 'lab':
		header("location:lab.php"); exit;
		break;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
	logoutUser();
}

?>
<!DOCTYPE html>
<html>
<title>Blood Bank</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-red.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css.css">
<script src="control_panel.js"></script>
<body>

	<div id="main" class="full-height">

		<?php
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
		?>

	</div>

</body>
</html> 