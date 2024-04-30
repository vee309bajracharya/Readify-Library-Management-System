<?php
session_start();
if (isset ($_SESSION['admin'])) {
  header("Location: ./adminDashboard.php"); //if admin is registered , redirect it to  home/dashboard page no need to signup again
}
?>

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
  <link
    href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- ==== Boxicons link ==== -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <!-- ==== RemixIcon link ==== -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />

  <!-- ==Inline CSS== -->
  <style>
    .signup__admin {
      width: 50%;
    }

    .admin__signup__container {
      display: grid;
      place-items: center;
    }

    .admin__signup__form__container {
      display: flex;
      flex-direction: column;
      margin-left: 4rem;
    }

    .toggle__admin {
      margin-left: 376px;
    }

    .register__admin {
      width: 48%;
      margin-left: 30rem;
    }
  </style>



</head>

<body bgcolor="#eee">

  <!-- =================================================================== -->

  <section class="signup__wrapper">
    <div class="admin__signup__container">

      <!-- =========== content left ============= -->
      <div class="signup__content__left signup__admin">
        <div class="signup__intro login__intro">
          <h3 style="text-align: center;">Admin Sign up</h3>

          <form action="./admin-Sign-up.php" method="POST" id="signupForm">
            <div class="admin__signup__form__container">

              <div class="fields">
                <label for="fullname">Full Name <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="fullname" id="fullname" placeholder="">
              </div>

              <div class="fields">
                <label for="username">Username <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="username" id="username" placeholder="">
              </div>

              <div class="fields">
                <label for="email">Email <span id="must">&#x002A;</span></label>
                <input type="email" class="input-fields" name="email" id="email" placeholder="">
              </div>

              <div class="fields">
                <label for="phone">Phone Number <span id="must">&#x002A;</span></label>
                <input type="tel" class="input-fields" id="phone_number" name="phone_number" placeholder="+977">
              </div>

              <div class="fields">
                <label for="password">Password <span id="must">&#x002A;</span></label>
                <input type="password" class="input-fields" name="pwd" id="pwd" placeholder="">
                <span class="password-toggle toggle__admin" onclick="togglePassword('pwd')">SHOW</span>

              </div>

              <div class="fields">
                <label for="cpassword">Confirm Password <span id="must">&#x002A;</span></label>
                <input type="password" class="input-fields" name="cpwd" id="cpwd" placeholder="">
                <span class="password-toggle toggle__admin" onclick="togglePassword('cpwd')">SHOW</span>

              </div>

              <div class="fields">
                <label for="address">Address <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="address" id="address" placeholder="">
              </div>



              <div class="fields">
                <input type="submit" class="btn-secondary btn-primary" name="cancel" value="Cancel"
                  onclick="resetForm()">
              </div>

              <div class="fields">
                <input type="submit" class="btn-primary" name="submit" value="Confirm" required>
              </div>

            </div>

        </div>
        <h5 style="text-align: center; font-size: 1.4rem; font-weight: 400;"> Already have an account ? <a
            href="./admin-Log-in.php">Log in</a> </h5>
        </form>

      </div>
    </div>

    <!--  ===== php section starts ====-->
    <?php
    if (isset ($_POST['submit'])) {
      $fullname = $_POST['fullname'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $phone_number = $_POST['phone_number'];
      $pwd = $_POST['pwd'];
      $cpwd = $_POST['cpwd'];
      $address = $_POST['address'];


      //HashPassword
      $pwdHash = password_hash($pwd, PASSWORD_DEFAULT);

      //for any errors in any fields
      $errors = array();

      //check if fields are empty
      if (empty ($fullname) || empty ($username) || empty ($email) || empty ($phone_number) || empty ($pwd) || empty ($cpwd) || empty ($address)) {
        array_push($errors, "Fill up required fields");
      }

      //  ====== fields validation ======
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Enter a valid email");
      }

      if (strlen($pwd) < 8) {
        array_push($errors, "Password must be atleast 8 characters long");
      }

      if ($pwd !== $cpwd) {
        array_push($errors, "Passwords do not match");
      }

      if (strlen($phone_number) != 10) {
        array_push($errors, "Mobile no. must contain 10 digits");
      }

      if (!preg_match("/^[a-zA-Z\s]*$/", $fullname)) {
        array_push($errors, "Fullname should only contain letters and spaces");
      }

      if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        array_push($errors, "Username should only contain alphanumeric characters");
      }

      require_once "../config.php"; //database config file
    

      // ==== check for duplicate email =====
      $sql = "SELECT * FROM admin WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);
      $rowCount = mysqli_num_rows($result);

      if ($rowCount > 0) {
        array_push($errors, 'Email already exists');
      }

      // ==== check for duplicate username ====
      $usernameCheckQuery = "SELECT * FROM admin WHERE username = '$username'";
      $usernameResult = mysqli_query($conn, $usernameCheckQuery);
      $usernameRowCount = mysqli_num_rows($usernameResult);

      if ($usernameRowCount > 0) {
        array_push($errors, 'Username already exists');
      }


      if (count($errors) > 0) {
        foreach ($errors as $error) {
          echo "<section class='alert-error-msg  register__admin'>$error</section>";
        }
      } else {



        // insert data into database
        $sql = "INSERT INTO admin(fullname, username, email, phone_number, pwd, address,pic)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

        //mysqli_stmt_init() -> mysqli_stmt_init() function initializes a statement and returns an object suitable for mysqli_stmt_prepare(). 
        $stmt = mysqli_stmt_init($conn);

        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
          $pic = './admin_profile/user__profile__default.png';

          mysqli_stmt_bind_param($stmt, "sssisss", $fullname, $username, $email, $phone_number, $pwdHash, $address, $pic);
          mysqli_stmt_execute($stmt);
          echo "<section class='alert-success-msg register__admin'>Successfully Registered!!! Proceed to login</section>";
        } else {
          die ("Something went wrong");
        }
      }
    }


    ?>


    <!--  ===== php section ends ====-->
  </section>


  <!-- ==== JavaScript  ==== -->
  <script>
    //reset the form using cancel button
    function resetForm() {

      var form = document.getElementById('signupForm'); //get the form by its id

      form.reset(); //reset form
    }

    // Toggle between showing and hiding the password
    function togglePassword(inputId) {
      var passwordInput = document.getElementById(inputId);
      var passwordToggle = document.querySelector(`#${inputId} + .password-toggle`);

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.textContent = "HIDE";
      } else {
        passwordInput.type = "password";
        passwordToggle.textContent = "SHOW";
      }
    }
  </script>

</body>

</html>