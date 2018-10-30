<?php

include("control_panel.php");

if (!isset($_SESSION['page'])) {
	if(!isset($_SESSION['login'])) {
		
	} else if (!isRegistered()) {
		header("location:register.php"); exit;
	} else {
		header("location:account.php"); exit;
	}
}

$email = $password = "";
$accountName = "NBTS";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);

  signupUser($email, $password);
}

function signupUser($email, $password) {
	$conn = mysqli_connect(constant('DB_HOST'), constant('DB_USERNAME'), constant('DB_PASSWORD'), constant('DB_NAME'))
	or die("error on con");
	$result = mysqli_query($conn, "SELECT email FROM logged_users WHERE email = '$email' ");
	if (mysqli_num_rows($result) == 1) {
		alertUser("Sign Up Error: User alerady exists!!");
	} else {
		@mysqli_query($conn, "INSERT INTO logged_users(email, password) VALUES('$email', '$password') ")or die("sql error");
		$id = mysqli_insert_id($conn);
			if($id != 0){
				storeLoginEmail($email);
				storeLoginSession("login");
				header("location:register.php"); exit;
			} else {
				alertUser("Failed to sign up");
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
	<div id="login" class="w3-display-container w3-theme-d5 full-height">
    	<div class="w3-display-middle half-height">
      		<form class="w3-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			    <h2 class="align-center w3-xxlarge"><?php echo $accountName; ?></h2>
			    <p>&nbsp;</p>
			    <p>
			    <label>&nbsp;</label>
			    <input class="w3-input w3-border w3-round" name="email" type="email" placeholder="Email address" required></p>
			    <p>
			    <label>&nbsp;</label>
			    <input class="w3-input w3-border w3-round" name="password" type="password" placeholder="Password" required></p>
			    <p>
			    <label>&nbsp;</label><br /><br />
			    <input type="submit" class="w3-btn half-height w3-card w3-theme-d4 w3-round" value="SIGN UP">
			    <a href="index.php"><input type="button" class="w3-btn" value="LOGIN" style="width: 300px;"></a></p>
      		</form>
    	</div>
  	</div>

</div>

</body>
</html> 