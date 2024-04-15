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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <!-- ==== RemixIcon link ==== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>



</head>

<body>
    <!-- ====== navbar starts =========== -->
    <header style='position: sticky !important;top: 0;left: 0;right: 0;z-index: 1000'>
        <nav class="custom-navbar">
            <div class="custom-navbar fixed-top">

                <ul class="custom-ul navbar-flex flex-row-reverse">

                <a href="#" style="text-decoration: none;">
                        <?php
                        // Display fullname and profile image if user is logged in
                        echo '<div class="custom-links d-flex align-items-center">';
                        echo '<img class="img-circle profile_img" width="35" height="35" src="' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover;">';
                        echo '<span class="admin" style="color:#000; font-size: 1.3rem;">' . $_SESSION['admin']  . ' </span>';

                        echo '</div>';
                        ?>
                    </a>
                    
                    <a href="./Approve.php"><i class='bx bx-bell'></i></a>
                    <!-- <i class='bx bxs-bell-ring' ></i> -->

                </ul>
            </div>
        </nav>
    </header>
    <!-- ====== navbar ends =========== -->

</body>
</html>