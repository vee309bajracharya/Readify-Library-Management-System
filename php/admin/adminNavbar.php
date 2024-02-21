<?php 
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ./admin-Log-in.php"); //if admin isn't logged in, redirect it to login page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Readify Library Management System</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css" />

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- ==== RemixIcon link ==== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>



</head>

<body>

    <!-- ====== navbar starts =========== -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid custom-navbar">
            <div class="navbar-header navbar-left">
            <span onclick="openNav()" class="toggle-trigger">&#9776;</span>
              </div>

              <ul class="nav navbar-nav navbar-right custom-ul">
                    <?php
                    // Display username and profile image if admin is logged in
                    echo '<div class="custom-links d-flex align-items-center">';
                    echo '<img class="img-circle profile_img" width="50" height="50" src="' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px;">';
                    echo '<span class="admin">' . $_SESSION['admin']  . ' </span>';

                    echo '</div>';
                    ?>
            </ul>


        </div>  
    </nav>
    <!-- ====== navbar ends =========== -->
    <!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>