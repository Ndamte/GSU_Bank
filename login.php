<?php
     session_start();
?>
<!DOCTYPE html>
<html>
     <head>
          <title>GSU Bank</title>
          <meta charset="UTF-8">
          <link rel="stylesheet" href="login_style.css">
     </head>
     <body>
          <?php
               // Error Messages
               $username= $usernameErr = "";
               $password= $passwordErr= "";
               $usr_n_passErr = "";
                $login_err ="";
              

               if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST["username"])) {
                         $usernameErr = "Name is required";
                    } 
                    if (!preg_match("/^[A-Za-z_]\w*$/",$_POST['username'])) {
                         $usernameErr = "*Only letters,numbers and underscore are allowed. Can not start with a number.";
                    } else {
                         $username = $_POST["username"];
                         $_SESSION["username"] = $username;
                    }

                    if (empty($_POST["password"])) {
                         $password = "password is required";
                    } 

                    if (!preg_match("/^[A-Za-z_0-9$][A-Za-z0-9_#*$]*$/",$_POST['password'])) {
                         $passwordErr = "*wrong password pattern.";
                    } else {
                         $password = $_POST["password"];
                         $_SESSION["password"] = $password;
                    }

                    if (empty($usernameErr) && empty($passwordErr)) {
                         header("Location: login-db-processor.php");
                         exit;
                    } else {
                         $usr_n_passErr= "*Incorrect username or password";
                    }

                   
               }	 
               if(!empty($_SESSION["error"])){
                $login_err = $_SESSION["error"];
                unset($_SESSION["error"]); // remove the error
              }
          ?>
          <div class="pic_header"> <img src="gsu.jpg"> </div>
          <h1 class= "login_header"> Login </h1>
          <form  method="post" action= " <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
               <div class="login_fields">
                    <div class="usr_n_span">
                         <label class="label" for="u_name"> Username 
                              <input class="input" type="text" id="u_name" name="username" required> 
                         </label> 
                         <span class= "error">  <?php echo $usernameErr; ?> </span> <br>
                    </div>

                    <div class="pass_n_span">
                         <label class="label" for="pass"> Password 
                              <input class="input" type="password" id="pass" name="password"  required >
                         </label> 
                         <span class= "error">  <?php echo $passwordErr; ?> </span> <br>
                    </div>

                    <div class= "submit_align">
                         <input type= "submit"><br>
                    </div>

                    <div class="mistake"> 
                         <span> <?php echo $usr_n_passErr; ?> </span> <br>
                         <span> <?php echo $login_err; ?> </span> <br>
                    </div>
               </div>
          </form>
     </body>
</html>