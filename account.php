<?php

include("control_panel.php");


if(!isset($_SESSION['login'])) {
	header("location:index.php"); exit;
} else if (!isRegistered()) {
	header("location:register.php"); exit;
} else {
	
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
  	$password = test_input($_POST["password"]);

  	if ($password == "AdmiN") {
  		storePageSession("admin");
  		header("location:admin.php"); exit;
  	} else {
  		alertUser("Access Denied");
  	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['donor'])) {
	storePageSession("donor");
	header("location:donor.php"); exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hospital'])) {
	if (isGrantedAccess("hospitals")) {
		storePageSession("hospital");
		header("location:hospital.php"); exit;
	} else {
		alertUser("Error: Hospital Access Denied");
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lab'])) {
	if (isGrantedAccess("labs")) {
		storePageSession("lab");
		header("location:lab.php"); exit;
	} else {
		alertUser("Error: Laboratory Access Denied");
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['requestor'])) {
	storePageSession("requester");
	header("location:requestor.php"); exit;
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

  	<div id="chooseAccount" class="w3-display-container w3-theme-l5 full-height">

		<form id="accountForm" class="w3-display-topright half-width w3-margin w3-right" 
			action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">  
			<!--<input id="admin_password" class="w3-input w3-border w3-round" name="password" type="password" placeholder="Admin Password" required></p>
		    <p>
		    <input id="submit" type="submit" class="w3-btn half-height w3-card w3-theme-d4 w3-round w3-right" value="SUBMIT"></p>-->
    	</form>

		<div class="w3-display-middle full-width">
	  	<h2 class="align-center w3-xxlarge"><?php echo constant("ACCOUNT_NAME"); ?></h2><br />

	  	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	  	<div id="cursor" class="w3-row w3-center">
	    	<div class="w3-col l2 w3-margin">
	      		<button type="submit" name="donor" class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
	        		<i class="fa fa-gift" style="font-size: 56px;color:red;"></i>
	        		<div class="w3-container">
	          			<p class="w3-xlarge"><b>Donor</b></p>
	        		</div>
	      		</button>
	    	</div>

	    	<div id="cursor" class="w3-col l2 w3-margin" onclick="hositalAccount()">
	      		<button type="submit" name="hospital" class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
	        		<i class="fa fa-hospital-o" style="font-size: 56px;color:red;"></i>
	        		<div class="w3-container">
	          			<p class="w3-xlarge"><b>Hospital</b></p>
	        		</div>
	      		</button>
	    	</div>

	    	<div id="cursor" class="w3-col l2 w3-margin" onclick="laboratoryAccount()">
	      		<button type="submit" name="lab" class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
	        		<i class="fa fa-hospital-o" style="font-size: 56px;color:red;"></i>
	        		<div class="w3-container">
	          			<p class="w3-xlarge"><b>Laboratory</b></p>
	        		</div>
	      		</button>
	    	</div>

	    	
	    	<div id="cursor" class="w3-col l2 w3-margin" onclick="hositalAccount()">
	      		<button type="submit" name="hospital" class="w3-card-4 w3-round-large w3-hover-green w3-center w3-margin w3-padding" style="width:100%">
	        		<i class="fa fa-question-circle-o" style="font-size: 56px;color:red;"></i>
	        		<div class="w3-container">
	          			<p class="w3-xlarge"><b>Requestor</b></p>
	        		</div>
	      		</button>
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
	</form>

	  </div>
	</div>
</div>

</div>

</body>
</html> 