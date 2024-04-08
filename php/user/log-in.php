<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: ./list_book_for_user.php"); //if user is registered , redirect it to  home/dashboard page
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Title icon -->
  <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

  <!-- ==== CSS Links ==== -->
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/responsive.css">

  <!-- ==== Google Fonts Link ==== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- ==== Boxicons link ==== -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

</head>

<body bgcolor="#eee">

  <!-- =================================================================== -->
  <section class="form__wrapper">
    <div class="form__container">
      <div class="box form__box">

        <div class="login__intro">
          <a href="../../pages/index.html"> <img src="../../svg/R__logo_2.svg"></a>
          <h2>Login</h2>
          <p>Welcome Back <br>
            <span>We’re thrilled to see you again &#x1F44B; <br>Please login to get back to your account</span>
          </p>
        </div>

        <!-- ========= Form ============== -->
        <form action="./log-in.php" method="POST">

          <div class="field input">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="">
          </div>

          <div class="field input">
            <label for="password">Password</label>
            <input type="password" name="pwd" id="pwd" placeholder="">
          </div>

          <div class="field">
            <input type="submit" class="btn-primary btn-submit" name="login" value="Login" required>

          </div>



          <div class="links">Don't have an account ?
            <a href="./sign-up.php">Sign Up</a>
          </div>

          <!-- ==== for admin login === -->
          <div class="links">Login as
            <a href="../admin/admin-Log-in.php"><b>Admin</b></a>
          </div>

        </form>



      </div>
    </div>

    <!-- =========== php section starts ============== -->
    <?php
    if (isset($_POST['login'])) {
      $email = $_POST['email'];
      $pwd = $_POST['pwd'];

      //if form is submitted empty
      if(empty($email)|| empty($pwd)){
        echo "<section class='center-text'>Enter email and password</section>";
      }else{
             
      //check if the entered email and password exists on database or not
      require_once "../config.php";

      $sql = "SELECT * FROM library_users WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);

      if ($user = mysqli_fetch_array($result)) {

        //checking encrypted pwd

        if (password_verify($pwd, $user['pwd'])) {

          //creating session as : dashboard page is available for registered users only
          session_start();
          $_SESSION['user'] = $user['username'];
          $_SESSION['pic'] = $user['pic'];

          header("Location: ./list_book_for_user.php");
          die();
        } else {
          echo "<section class='center-text'>Password does not match</section>";
        }
      } else {
        echo "<section class='center-text'>Email does not exist</section>";
      }

      }
    }

    ?>
    <!-- =========== php section ends ============== -->
  </section>

  <!-- ==== JavaScript Link ==== -->
  <script src="../../js/app.js"></script>


</body>

</html>