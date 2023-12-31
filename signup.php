<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>GSU Bank</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="signup_styles.css">
	</head>
	<body>
		<?php
			$username= $usernameErr = "";
			$email = $emailErr ="";
			$password= $passwordErr= "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				// Username
				if (empty($_POST["username"])) {
					$usernameErr = "*Name is required";
				} else if (!preg_match("/^[A-Za-z_][A-Za-z0-9_]*$/",$_POST["username"])) {
					$usernameErr = "*Only letters,numbers and underscore are allowed. Can not start with a number.";
				} else {
					$username = $_POST["username"];
					$_SESSION["username"] = $username;
				}

				// Email
				if (empty($_POST["email"])) {
					$emailErr = "*Email is required";
				} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
					$emailErr = "*Invalid email format";
				} else {
					$email = $_POST["email"];
					$_SESSION["email"] = $email;
				}

				// Password
				if (empty($_POST["password"])) {
					$password = "*password is required";
				} else if (!preg_match("/^[A-Za-z_0-9$][A-Za-z0-9_#*$]*$/",$_POST["password"])) {
					$passwordErr = "*Only letters,numbers and underscore are allowed.";
				} else {
					$password = $_POST["password"];
					$_SESSION["password"] = $password;
				}

				// Check for blank entries
				if (empty($usernameErr) && empty($emailErr) && empty($passwordErr)) {
					// No errors, proceed with signup process
					header("Location: signup-db-processor.php");
					exit;
				}
			}
		?>
		<div class="pic_header"> <img src="gsu.jpg"> </img>  </div>
		<div class="main_class"> 
			<div class="center_header">
				<div class="signup_header"> 
					<p> Sign up <p>
				</div>
			</div>

			<form class="form" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
				<div class = "signup_fields">
					<div class ="usr_n_span">
						<label> Username 
							<input type="text" name="username" required>
						</label>
						<span class= "error">  <?php echo $usernameErr; ?> </span> <br>
					</div>

					<div class ="eml_n_span">
						<label > Email  
							<input type="text" name="email" > 
						</label>
						<span class= "error">  <?php echo $emailErr; ?> </span> <br>
					</div>

					<div class ="pass_n_span">	
						<label > Password  
							<input type="password" name="password"  required>
						</label>
						<span class= "error">  <?php echo $passwordErr; ?> </span> <br>
					</div>
					<div class= "submit_align">
						<input type= "submit"><br>
					</div>
				</div>	
			</form>
		</div>
	</body>
</html>