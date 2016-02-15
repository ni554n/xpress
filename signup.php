<!DOCTYPE html>
<?php
session_start();
require_once 'functions.php';
?>
<html>
    <head>
        <meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <title>Sign Up | Xpress</title> -->
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

		<!-- Style sheets -->
		<link rel="stylesheet" href="css/reset.css" type="text/css"> <!-- CSS reset -->
        <link rel="stylesheet" href="css/signup.css" type="text/css"> <!-- main styling -->


		<script src="js/jquery-2.1.1.js" type="text/javascript"></script> <!-- JQuery -->
        <script src = "js/signup.js" type = "text/javascript"></script><!-- sign up functionality -->
    </head>
    <body>
        <?php
        $error1 = $error = $signup_user = $signup_pass = $hash_pass = "";
        if (isset($_SESSION['user']))
            destroySession();

        if (isset($_POST['user']) && isset($_POST['signup'])) {
            $signup_user = sanitizeString($_POST['user']);
            $signup_pass = sanitizeString($_POST['pass']);

            //for hashing
           if ($signup_pass != "") {
             $hash_pass =  md5("hash".$signup_pass);
           }

            if ($signup_user == "" || $signup_pass == "") {
              $error1 = '<div class="notify errorbox"> <h1>Warning!</h1> <span class="alerticon"><img src="img/notificationBox/error.png" alt="error" /></span> <p>Not all fields were entered. Please fill in all fields</p> </div>';
            }
            else {
                $result = queryMysql("SELECT * FROM members WHERE user='$signup_user'");

                if ($result->num_rows) {
                    $error1 = 'That username already exists. Please try another.';
                    echo "<script type='text/javascript'>alert('$error1');</script>";
                }
                else {
                    queryMysql("INSERT INTO members VALUES('$signup_user', '$hash_pass')");
                    //die("<h4>Account created</h4>Please <a href = \"signin.php\"> Log in. </a><br><br>");
                    header("location:login.php");
                }
            }
        }
        ?>

		<img id="logo" src="img/logo.png" alt="logo"/>

		<div id="signup">
			<form class="signup-form" method="post" action="signup.php">
				<p class="fieldset">
					<label class="image-replace cd-username" for="signup-username">Username</label>
					<input class="full-width has-padding has-border" id="signin-email" name="user" type="text" placeholder="Username" value="<?= $signup_user ?>" required/>
					<span id='signup-username'></span><br>
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signin-password">Password</label>
					<input class="full-width has-padding has-border" id="signin-password" type="text"  name="pass" placeholder="Password" value="<?= $signup_pass ?>" required/>
				</p>

				<p class="fieldset">
					<input class="full-width" type="submit" value="Create account" />
					<!--To style -->
					<span class="cd-error-message" ><?php echo "$error" ?></span>
				</p>
			</form>
		</div>

		<!--
        <div id="content">

            <!-- needs fixing after implementation
            <?php echo "$error1"?>
        </div>-->
    </body>
</html>
