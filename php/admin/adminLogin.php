<?php 
    session_start();
    if(isset($_SESSION['user'])){
        header("Location: ../user/home.php"); //if user is registered , redirect it to  home/dashboard page
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

  <!-- ==== RemixIcon link ==== -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />

</head>

<body bgcolor="#eee">

  <!-- =================================================================== -->
  <section class="form__wrapper">
    <div class="form__container">
      <div class="box form__box">

        <div class="login__intro login__intro_admin">
          <img src="../../svg/R__logo_2.svg">
   
          <p>Welcome Admin <br>
           
          </p>
        </div>

        <!-- ========= Form ============== -->
        <form action="../validation/log-in.php" method="POST">

          <div class="field input">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="">
          </div>

          <div class="field input">
            <label for="password">Password</label>
            <input type="password" name="pwd" id="pwd" placeholder="">


          </div>

          <div class="field">
            <input type="submit" class="btn-primary" name="login" value="Login" required>

          </div>

          <div class="links">Don't have an account ?
            <a href="../validation/sign-up.php" target="_blank">Sign Up</a>
          </div>


        </form>
      </div>

    </div>

    <!-- =========== php section starts ============== -->
    <?php 
        
     ?>
    <!-- =========== php section ends ============== -->
  </section>

  <!-- ==== JavaScript Link ==== -->
  <script src="../../js/app.js"></script>
</body>

</html>