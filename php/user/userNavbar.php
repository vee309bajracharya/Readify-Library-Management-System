<?php
session_start();

if (!isset ($_SESSION['user'])) {
    header("Location: ./log-in.php"); // Redirect user to login page if not logged in
    exit();
}

include "../config.php"; // Include database connection file
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
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- ===== Bootstrap link ======== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



</head>

<body>

    <!-- ====== navbar starts =========== -->

    <header style='position: sticky !important;top: 0;left: 0;right: 0;z-index: 1000; display: none;'>
        <nav class="custom-navbar ">
            <div class="custom-navbar fixed-top">


                <ul class="custom-ul navbar-flex flex-row-reverse ">

                    <li class="nav-item">

                        <!-- Profile dropdown -->
                        <div class="nav-link dropdown">
                            <span class="dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">

                                <!-- Profile image -->
                                <img class="img-circle profile_img" width="40" height="40"
                                    src="./images/<?php echo $_SESSION['pic']; ?>"
                                    style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover;">

                                <!-- User name -->
                                <span class="user" style="color:#000;">
                                    <?php echo $_SESSION['user']; ?>
                                </span>
                            </span>

                            <!-- Dropdown menu -->
                            <div class="dropdown-menu custom-dropdown" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="./myProfile.php">View Profile</a>
                                <a class="dropdown-item" href="./change_password.php">Change Password</a>
                                <a class="dropdown-item" href="./logOut.php">Log Out</a>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <!-- Bell icon -->
                        <a href="#"><i class="bx bx-bell"></i></a>
                    </li>
                </ul>

            </div>
        </nav>

  
    </header>

    <!-- ====== navbar ends =========== -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>
</body>

</html>