<?php 
    session_start();
    if(isset($_SESSION['admin'])){
        header("Location: ./adminDashboard.php"); //if admin is registered , redirect it to  home/dashboard page
      exit();
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

        <div class="login__intro">
          <a href="../../pages/index.html"><img src="../../svg/R__logo_2.svg"></a>
          <h2>Login</h2>
          <p>Welcome Admin!<br>
            <span>Login to get back to your dashboard</span>
          </p>
        </div>

        <!-- ========= Form ============== -->
        <form action="./admin-Log-in.php" method="POST" style='margin-top: 3rem;'>

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
        </form>
      </div>
    </div>

    <!-- =========== php section starts ============== -->
    <?php 
      if(isset($_POST['login'])){
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];

      //if form is submitted empty
      if(empty($email)|| empty($pwd)){
        $_SESSION['msg'] = "Enter email and password!";
        $_SESSION['msg_code'] = "error";
      }else{
        //check if the entered email and password exists on database or not

        require_once "../config.php";

        $sql = "SELECT * FROM `admin` WHERE email = '$email'";
        $result = mysqli_query($conn,$sql);
        
        if($admin= mysqli_fetch_assoc($result)){

          //checking encrypted pwd
          if(password_verify($pwd,$admin['pwd'])){

            //creating session as : dashboard page is available for registered admin only
            $_SESSION['admin'] = $admin['username'];
            $_SESSION['pic'] = $admin['pic'];
            header("Location: ./adminDashboard.php");
            die();
          }else{
            $_SESSION['msg'] = "Password does not match";
            $_SESSION['msg_code'] = "error";
          }

        }else{
          $_SESSION['msg'] = "Email does not exist";
          $_SESSION['msg_code'] = "error";
        }
      }
      }
      
    
    ?>
    <!-- =========== php section ends ============== -->
  </section>

      <!-- jquery, popper, bootstrapJS -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php 
          include ('../sweetAlert/sweetalert_actions.php');
    ?>
  
</body>
</html>
