<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
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
          <img src="../../svg/R__logo_2.svg">
        </div>

        <div class="login__intro login__intro__admin">
          <p>Welcome Admin</p>
        </div>


        <!-- ========= Form ============== -->
        <form action="" method="POST" class="admin-form-container">

          <div class="field input">
            <label for="name">Name</label>
            <input type="text" name="adminName" id="adminName">
          </div>

          <div class="field input">
            <label for="password">Password</label>
            <input type="password" name="Adinpwd" id="Adminpwd">


          </div>

          <div class="field">
            <input type="submit" class="btn-primary btn-submit" name="login" value="Login" required>

          </div>

        </form>
      </div>

    </div>


  </section>

</body>

</html>