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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>



























    <!-- ====== navbar starts =========== -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand-active" href="./userHome.php">
                    <img src="../../svg/logo-1.svg" alt="">
                </a>
            </div>

            <ul class="nav navbar-nav">
                <li><a href="">Home</a></li>
                <li><a href="./books.php">Books</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- check if user is logged in or not -->

                <?php
                session_start();
                if (isset($_SESSION['user'])) {
                    echo '<ul class="navbar-nav ms-auto">
                    <div class="nav-item text-white me-3">
                        <span class="nav-link text-white">' . $_SESSION['user'] . '</span>
                    </div>
                    <a class="nav-link text-white" href="./logOut.php"> Logout</a>
                </ul>';
                }

                ?>
            </ul>






        </div>
        </div>
    </nav>
    <!-- ====== navbar ends =========== -->


    <!-- === Bootstrap JavaScript Link==== -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->

</body>

</html>