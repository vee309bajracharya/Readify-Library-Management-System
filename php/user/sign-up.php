<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: ./list_book_for_user.php"); // Redirect to home/dashboard page if user is registered
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
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- ==== Boxicons link ==== -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">


</head>

<body bgcolor="#eee">

  <!-- =================================================================== -->

  <section class="signup__wrapper">
    <div class="signup__container">

      <!-- =========== content left ============= -->
      <div class="signup__content__left">
        <div class="signup__intro login__intro">
          <h3>Sign up</h3>

          <form action="./sign-up.php" method="POST" id="signupForm">
            <div class="signup__form__container">

              <div class="fields">
                <label for="fullname">Full Name <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="fullname" id="fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="username">Username <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="email">Email <span id="must">&#x002A;</span></label>
                <input type="email" class="input-fields" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="phone">Phone Number <span id="must">&#x002A;</span></label>
                <input type="tel" class="input-fields" id="phone_number" name="phone_number" value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="password">Password <span id="must">&#x002A;</span></label>
                <input type="password" class="input-fields" name="pwd" id="pwd" value="<?php echo isset($_POST['pwd']) ? htmlspecialchars($_POST['pwd']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="cpassword">Confirm Password <span id="must">&#x002A;</span></label>
                <input type="password" class="input-fields" name="cpwd" id="cpwd" value="<?php echo isset($_POST['cpwd']) ? htmlspecialchars($_POST['cpwd']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="address">Address <span id="must">&#x002A;</span></label>
                <input type="text" class="input-fields" name="address" id="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
              </div>

              <div class="fields">
                <label for="library_card_number">Library Card Number</label>
                <input type="text" class="input-fields" name="library_card_number" id="library_card_number" value="">
              </div>

              <div class="fields">
                <input type="submit" class="btn-secondary btn-primary" name="cancel" value="Cancel" onclick="resetForm()">
              </div>

              <div class="fields">
                <input type="submit" class="btn-primary" name="submit" value="Confirm" required>
              </div>

            </div>

        </div>
        <div class="links">
          By signing up you have agreed to our <a href="../../pages/terms-and-conditions.html">Terms and
            Conditions</a> along with <a href="../../pages/privacy-policy.html">Privacy Policy</a>
          <br> <br> <small> Already have an account ? </small><a href="./log-in.php">Log in</a>
        </div>
        </form>

      </div>

      <!-- =========== content right ============= -->
      <div class="signup__content__right">
        <div class="welcome__content">
          <a href="../../pages/index.html">
            <img src="../../svg/R__logo_1.svg" alt="Readify Logo">
          </a>
          <h3>Welcome to <br><span>Readify</span> </h3>
        </div>

      </div>
    </div>

    <!--  ===== php section starts ====-->
    <?php
    if (isset($_POST['submit'])) {
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

      //  ====== fields validation ======

      if(empty($fullname)){
        array_push($errors, "Full Name is required");
      }else{
          if (!preg_match("/^[a-zA-Z\s]*$/", $fullname)) {
            array_push($errors, "Fullname should only contain letters and spaces");
          }
      }

      if(empty($username)){
        array_push($errors,"Username is required");
      }else{
          if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            array_push($errors, "Username should only contain alphanumeric characters");
          }
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Enter a valid email");
      }

      if(empty($phone_number)){
        array_push($errors,"Enter a valid phone number");
      }else{
        if (strlen($phone_number) != 10) {
          array_push($errors, "Mobile number must contain 10 digits");
        }
      }

      if(empty($pwd)){
        array_push($errors,"Enter your password");
      }else{
          if (strlen($pwd) < 8) {
            array_push($errors, "Password must be atleast 8 characters long");
          }
      }
      
      if ($pwd !== $cpwd) {
        array_push($errors, "Passwords do not match");
      }

      if (empty($address)) {
        array_push($errors, "Enter your address");
      } else {
        if (!preg_match("/^[a-zA-Z0-9\s,]+$/", $address)) {
          array_push($errors, "Address contains letters, digits, spaces and commas only");
        }
      }

      require_once "../config.php";

      // ==== check for duplicate email and username =====
      $sql = "SELECT * FROM library_users WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);
      $rowCount = mysqli_num_rows($result);

      if ($rowCount > 0) {
        array_push($errors, 'Email already exists');
      }

      $usernameCheckQuery = "SELECT * FROM library_users WHERE username = '$username'";
      $usernameResult = mysqli_query($conn, $usernameCheckQuery);
      $usernameRowCount = mysqli_num_rows($usernameResult);

      if ($usernameRowCount > 0) {
        array_push($errors, 'Username already exists');
      }

      if (count($errors) > 0) {
        foreach ($errors as $error) {
          echo "<section class='alert-error-msg'>$error</section>"; // display the error
        }
      } else {

        // Generate a random alphanumeric library card number
        $library_card_number = generateRandomString('Rfy', 8);

        // insert data into database
        $sql = "INSERT INTO library_users(fullname, username, email, phone_number, pwd, address, library_card_number,pic)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        //mysqli_stmt_init() -> mysqli_stmt_init() function initializes a statement and returns an object suitable for mysqli_stmt_prepare(). 
        $stmt = mysqli_stmt_init($conn);

        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
          $pic = './images/user__profile__default.png';

          mysqli_stmt_bind_param($stmt, "sssissss", $fullname, $username, $email, $phone_number, $pwdHash, $address, $library_card_number, $pic);
          mysqli_stmt_execute($stmt);
          echo "<section class='alert-success-msg'>Successfully Registered!!! Your Library Card Number is $library_card_number. Proceed to 
          <a href='./log-in.php' class='heading-small' style='color: white; font-family: var(--primary-font);'>Login</a></section>";

          // Clear all input fields after successful registration
          echo "<script>document.getElementById('fullname').value = '';</script>";
          echo "<script>document.getElementById('username').value = '';</script>";
          echo "<script>document.getElementById('email').value = '';</script>";
          echo "<script>document.getElementById('phone_number').value = '';</script>";
          echo "<script>document.getElementById('pwd').value = '';</script>";
          echo "<script>document.getElementById('cpwd').value = '';</script>";
          echo "<script>document.getElementById('address').value = '';</script>";
        } else {
          die("Something went wrong");
        }
      }
    }

      // Function to generate a random alphanumeric string
      function generateRandomString($prefix, $length)
      {
        // Define the characters for the numbers
        $numbers = '0123456789';

        // Initialize the random string with the fixed prefix
        $randomString = $prefix;

        // Calculate the remaining length for random numbers
        $remainingLength = $length - strlen($prefix);

        // Generate random numbers and append them to the string
        for ($i = 0; $i < $remainingLength; $i++) {
          $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
        }

        return $randomString;
      }
      $randomString = generateRandomString('Rfy', 8); //'Rfy' and 5random numbers
    ?>

    <!--  ===== php section ends ====-->
  </section>


  <!-- ==== JavaScript  ==== -->
  <script>
    //reset the form using cancel button
    function resetForm() {

      var form = document.getElementById('signupForm');

      form.reset();

      // also clear all input fields after form is half filled and clicked on cancel button
      document.getElementById('fullname').value = '';
      document.getElementById('username').value = '';
      document.getElementById('email').value = '';
      document.getElementById('phone_number').value = '';
      document.getElementById('pwd').value = '';
      document.getElementById('cpwd').value = '';
      document.getElementById('address').value = '';
    }
  </script>

</body>
</html>