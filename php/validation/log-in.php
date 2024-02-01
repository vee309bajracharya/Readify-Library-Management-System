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

  <!-- ====== php validation starts here ===== -->

  <?php

  //variables
  $email = $password  = "";
  $emailErr = $passwordErr = "";

  if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    //======== email validation ============
    if (empty($_POST['email'])) {
      $emailErr = 'Please enter your email'; //if email is empty
    } else {
      $email = test_input($_POST['email']); // a proper valid email

      //if not a valid email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = 'Invalid Email Format';
      }
    }

    //======== password validation ===========
    if (empty($_POST['password'])) {
      $passwordErr = "Please enter a password";
    }
    else {
      $password  = test_input($_POST['password']);

      //check password format
      if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $password)) {
        $passwordErr = "Use atleast 8 characters. Include both an uppercase,lowercase and a number";
      }
    }

  }

  //test_input function

  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  ?>
  <!-- ====== php validation ends here ===== -->


  <!-- =================================================================== -->
  <section class="form__wrapper">
    <div class="form__container">
      <div class="box form__box">

        <div class="login__intro">
          <img src="../../svg/R__logo_2.svg">
          <h2>Login</h2>
          <p>Welcome Back <br>
            <span>We’re thrilled to see you again &#x1F44B; <br>Please login to get back to your account</span>
          </p>
        </div>

        <!-- ========= Form ============== -->
        <form action="" method="POST">

          <div class="field input">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="">
            <span class="error-msg"><?php echo $emailErr; ?></span>
          </div>

          <div class="field input">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="">
            <span class="error-msg"><?php echo $passwordErr; ?></span>

          </div>

          <div class="field">
            <input type="submit" class="btn-primary" name="submit" value="Login" required>

          </div>

          <div class="links">Don't have an account ?
            <a href="../validation/sign-up.php" target="_blank">Sign Up</a>
          </div>


        </form>
      </div>

    </div>
  </section>

  <!-- ==== JavaScript Link ==== -->
  <script src="../../js/app.js"></script>
</body>

</html>