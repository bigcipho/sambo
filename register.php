<?php

include("control_panel.php");
if (!isset($_SESSION['page'])) {
	if(!isset($_SESSION['login'])) {
		header("location:index.php"); exit;
	} else if (!isRegistered()) {
		
	} else {
		header("location:account.php"); exit;
	}
}

$name = $surname = $phone = $city = $sex = $dob = $address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$name = test_input($_POST["name"]);
  	$surname = test_input($_POST["surname"]);
  	$phone = test_input($_POST["phone"]);
  	$city = test_input($_POST["city"]);
  	$sex = test_input($_POST["sex"]);
  	$dob = test_input($_POST["dob"]);
  	$address = test_input($_POST["address"]);

  	registerUser($name, $surname, $phone, $city, $sex, $dob, $address);
}

function registerUser($name, $surname, $phone, $city, $sex, $dob, $address) {
	$email = $_SESSION['email'];
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT id FROM logged_users WHERE email = '$email'");
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		@mysqli_query($conn, "INSERT INTO users(user_id, name, surname, phone, dob, sex, city, address) 
			VALUES('$id', '$name', '$surname', '$phone', '$dob', '$sex', '$city', '$address') ")or die("sql error");
		$id = mysqli_insert_id($conn);
			if($id != 0){
				header("location:account.php"); exit;
			}
	}
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
  	<div id="registration" class="w3-display-container w3-theme-d5 full-height">
	    <div class="w3-display-middle half-width">
	      <form class="w3-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	        <h3 class="align-center w3-xxlarge"><?php echo constant("ACCOUNT_NAME"); ?></h3>
	        <p>&nbsp;</p>
	        <p>
	        <label>&nbsp;</label>
	        <input class="w3-input w3-border w3-round" name="name" type="text" placeholder="Name" required></p>
	        
	        <p>
	        <input class="w3-input w3-border w3-round" name="surname" type="text" placeholder="Surname" required></p>

	        <p>
	        <input class="w3-input w3-border w3-round" name="phone" type="number" placeholder="Phone Number" required></p>
	        
	        <p>
	        <input class="w3-input w3-border w3-round" name="city" type="text" placeholder="City" required></p>
	        
	        <p>
	        <input class="w3-input w3-border w3-round" name="sex" type="text" placeholder="Sex" required></p>

	        <p>
	        <input class="w3-input w3-border w3-round" name="dob" type="text" placeholder="Date of Birth ie 27-06-1990" required></p>

	        <p>
	        <input class="w3-input w3-border w3-round" name="address" type="text" placeholder="Home Address" required></p>

	        <p>
	        <label>&nbsp;</label><br /><br />
	        <input type="submit" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="DONE">
	      </form>
	    </div>
  	</div>

</div>

</body>
</html> 