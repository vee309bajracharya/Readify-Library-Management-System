<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>

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

  <section class="signup__wrapper">
    <div class="signup__container ">

      <!-- ==== php section === -->
      <!-- <?php

      // include("../config.php");


      // if (isset($_POST['submit'])) {
      //   $fullname = $_POST['fullname'];
      //   $username = $_POST['username'];
      //   $address = $_POST['address'];
      //   $phone_number = $_POST['phone_number'];
      //   $email = $_POST['email'];
      //   $password = $_POST['password'];
      //   $library_card_number = $_POST['library_card_number'];
      // }

      ?> -->


      <div class="signup__content__left">
        <div class="signup__intro login__intro">
          <h3>Sign up</h3>

          <form action="" method="POST">
            <div class="signup__form__container">

              <div class="fields">
                <label for="fullname">Full Name <span id="must">&#x002A;</span></label>
                <input type="text" name="fullname" id="fullname" placeholder="" required>
              </div>

              <div class="fields">
                <label for="username">Username <span id="must">&#x002A;</span></label>
                <input type="text" name="username" id="username" placeholder="" required>
              </div>

              <div class="fields">
                <label for="email">Email <span id="must">&#x002A;</span></label>
                <input type="email" name="email" id="email" placeholder="" required>
              </div>

              <div class="fields">
                <label for="phone">Phone Number <span id="must">&#x002A;</span></label>
                <input type="tel" id="phone_number" name="phone_number" placeholder="+977" required>
              </div>

              <div class="fields">
                <label for="password">Password <span id="must">&#x002A;</span></label>
                <input type="password" name="password" id="password" placeholder="" required>
              </div>

              <div class="fields">
                <label for="cpassword">Confirm Password <span id="must">&#x002A;</span></label>
                <input type="password" name="cpassword" id="cpassword" placeholder="" required>
              </div>

              <div class="fields">
                <label for="address">Address <span id="must">&#x002A;</span></label>
                <input type="text" name="address" id="address" placeholder="" required>
              </div>

              <div class="fields">
                <label for="library_card_number">Library Card Number</label>
                <input type="text" name="library_card_number" id="library_card_number" placeholder="">
              </div>

              <div class="fields">
                <input type="submit" class="btn-primary" name="submit" value="Cancel" required>
              </div>

              <div class="fields">
                <input type="submit" class="btn-primary" name="submit" value="Confirm" required>
              </div>

            </div>

        </div>
        <div class="links">By signing up you have agreed to our <a href="../../pages/terms-and-conditions.html">Terms and
            Conditions</a> along with <a href="../../pages/privacy-policy.html">Privacy Policy</a>
          <br> <br> <small> Already have an account ? </small><a href="../validation/log-in.php" target="_blank">Log in</a>
        </div>
        </form>

      </div>



      <div class="signup__content__right">
        <div class="welcome__content">
          <img src="../../svg/R__logo_1.svg" alt="">
          <h3>Welcome to <br><span>Readify</span> </h3>
        </div>

      </div>

    </div>

  </section>


  <!-- ==== JavaScript Link ==== -->
  <script src="../../js/app.js"></script>
</body>

</html>