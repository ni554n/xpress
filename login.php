<?php
// session_start();
// require_once 'functions.php';
require_once 'signup.php';
?>
<html>
    <head>
        <!-- <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"> -->

        <title>Log In | Xpress</title>
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="css/reset.css" type="text/css"> <!-- CSS reset -->
        <link rel="stylesheet" href="css/login.css" type="text/css"> <!-- main styling -->


        <!-- <script src="js/jquery-2.1.1.js"></script> -->
        <script src="js/showpassword.js"></script>
    </head>
    <body>
        <?php
        $error = $login_user = $login_pass = $hash_pass = "";

        if (isset($_POST['user'])) {
            $login_user = sanitizeString($_POST['user']);
            $login_pass = sanitizeString($_POST['pass']);
            if ($login_pass != "") {
              $hash_pass =  md5("hash".$login_pass);
            }
            if ($login_user == "" || $login_pass == "")
                $error = "<span class='error'>Not all fields were entered.</span>";
            else {
                $result = queryMySQL("SELECT user,pass FROM members
							WHERE user='$login_user' AND pass='$hash_pass'");

                if ($result->num_rows == 0) {
                    $error = "Username / Passward invalid.";
                    echo "<script type='text/javascript'>alert('$error');</script>";
                } else {
                    $_SESSION['user'] = $login_user;
                    $_SESSION['pass'] = $hash_pass;
                    if (isset($_POST['signup'])) {
                      header("location:profile.php");
                    } else {
                      header("location:members.php");
                    }
                }
            }
        }
        ?>


        <img id="logo" src="img/logo.png" alt="logo"/>


        <div id="login">
            <form class = "login-form" method='post' action='login.php'>
                <p class="fieldset">
                    <label class="image-replace cd-username fieldname" for="signin-email">Username</label>
                    <input type='text' class="full-width has-padding has-border" id="signin-email" maxlength='16' placeholder="Username" name='user' value='<?= $login_user ?>' autocomplete="off" required/><br>
                </p>
                <p class="fieldset">
                    <label class="image-replace cd-password fieldname" for="signin-password">Password</label>
                    <input class="full-width has-padding has-border" id="signin-password" type='password' maxlength='16'  placeholder="Password" name='pass' value='<?= $login_pass ?>' required/>
                    <a href="#" class="hide-password">Show</a>
                </p>
                <p class="fieldset">
                    <input class="half-width fieldname" name='login' type='submit' value='Log In'>
                    <input class="half-width fieldname" name='signup' type='submit' value='Sign Up'>
                </p>
            </form>

        </div>
    </body>
</html>
