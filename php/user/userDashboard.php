<?php
require_once "../config.php"; //database connection file


// Update the status of expired books
if (isset($_SESSION['admin'])) {
    $expireQuery = "UPDATE issue_book SET approve = 'Expired' WHERE `return` < CURDATE() AND approve = 'Approved'";
    mysqli_query($conn, $expireQuery);
}

if (isset($_SESSION['admin'])) {
    // Update the status of books considered lost if their approval status is 'Approved'
    $bookLostQuery = "UPDATE issue_book 
    SET approve = 'Book Lost ' 
    WHERE (DATEDIFF(CURDATE(), `return`) > 30) AND (approve = 'Approved' OR approve = 'Expired')";
    mysqli_query($conn, $bookLostQuery);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- ==== RemixIcon link ==== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css" rel="stylesheet" />


</head>

<body>
    <!-- Sidebar starts -->
    <div id="mySidenav" class="sidenav">
        <div class="logo-container">
            <a href="../../pages/index.html">
                <img src="../../svg/logo-1.svg" alt="Readify Logo" class="sidebar_logo">
            </a>
        </div>

        <div class="links">
            <a href="./list_book_for_user.php" class="sidebar-links"><i class='bx bxs-dashboard'></i> Dashboard</a>
            <a href="./myProfile.php" class="sidebar-links"><i class='bx bxs-user-circle'></i> My Profile</a>
            <a href="./change_password.php" class="sidebar-links"><i class="ri-lock-password-fill"></i> Change Password</a>
            <a href="./Request.php" class="sidebar-links"><i class='bx bxs-book'></i> Book Request</a>
            <a href="./issue_info.php" class="sidebar-links"><i class='bx bxs-book'></i> View Requested Books</a>
            <a href="./Expired.php" class="sidebar-links"><i class='bx bx-library'></i> Book Status</a>
            <a href="./fine.php" class="sidebar-links"><i class='bx bxs-wallet-alt'></i> Fine Details</a>
            <a href="./about_readify.php" class="sidebar-links"><i class='bx bxs-help-circle'></i> Support and Help</a>
        </div>

        <div class="bottom-nav-info d-flex align-items-center gap-3">
            <div>
            <img width="70" height="70"
                  src="./images/<?php echo $_SESSION['pic']; ?>"
                  style="background-color: white; border-radius: 5px !important; overflow: hidden; object-fit:cover;">

            </div>
            <div style="display: grid;" class="user">
                    <a href="./myProfile.php" class="user fw-semibold" style='color: white;'><?php echo $_SESSION['user']; ?></a>
                <small class="fw-lighter fs-6">User</small>
            </div>
            <div>
            <a href="./logOut.php" class="sidebar-links h-25"><i class="bx bx-log-out"></i></a>

            </div>
        </div>
    </div>
    <!-- Sidebar ends  -->
</body>

</html>