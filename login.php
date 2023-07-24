<?php 

     session_start();
      if (isset($_SESSION["Id"])){
        session_unset();
        session_destroy();
      } 
      
      require("classes/dal.php");
      require("classes/login-signup_dal.php");
      require("classes/student_dal.php");

      $login = new LoginSignup_DAL();   
      $student_info = new Student_DAL();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("header.php"); ?>
  <link rel="stylesheet" href="css/login-signup-page.css">
  <title>Login Page</title>
</head>
<body>
  <?php require("navbar.php"); ?>
  <main>
    <div class="outer-container">
      <div class="login-container">
        <form action="" method="POST">
          <h1>Login</h1>
          <?php if(isset($_POST["login"])) echo "<p id='message' style='text-align:center; color:#f00; margin-top:-1.5em;'>Wrong Email or Password!</p>";
                else if(isset($_GET["PasswordChanged"]) && $_GET["PasswordChanged"]==1) echo "<p id='message' style='text-align:center; color:#0ef; margin-top:-1.5em;'>Password Changed Successfully</p>";
          ?>
          <div class="input-box">
            <input type="text" name="email" required/>
            <span>Email</span>
            <i class="fa-solid fa-user fa-lg" style="color: #fff;"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" required/>
            <span>Password</span>
            <span class="eye-icons">
              <i class="fa-solid fa-eye fa-lg" style="color: #fff;"></i>
              <i class="fa-solid fa-eye-slash fa-lg" style="color: #fff;"></i>
            </span>
          </div>
          <div class="link">
            <a href="forgot-password.php">Forgot Password</a>
            <a href="signup.php">SignUp</a>
          </div>
          <div class="button-shadow">
            <input id="login-button" type="submit" class="submit-button" name="login" value="Login" />
            <div class="after"></div>
          </div>
        </form>
        <?php             

            if(isset($_POST["login"]))
            {
          
              $user_email = $_POST["email"];
              $user_password = $_POST["password"];

              

              $result = $login -> login($user_email,$user_password);
              
              //if the user requesting to Login is an Admin
              if($result == "Admin"){
            
                $user_info = $login -> getUserInfo($user_email,$user_password);

                $_SESSION["email"] = $user_email;
                $_SESSION["pass"] = $user_password;
                $_SESSION["Id"] = $user_info['Id'];
                $_SESSION['user_type']='admin';
                header("Location: admin-page.php");
              }
              else if ($result)
              {  
                $info = $student_info -> getStudentInfo($result);
                
                $_SESSION["email"] = $user_email;
                $_SESSION["pass"] = $user_password;
                $_SESSION["Id"] = $info[0]["StudentId"];
                $_SESSION['user_type']='student';
                header("Location: user-page.php");
              }
            }      
          ?>
      </div>
    </div>
  </main>
  <?php require("footer.php"); ?>
  <script src="js/pass-visible-invisible.js"></script>
  <script src="js/remove-message.js"></script>
</body>
</html>