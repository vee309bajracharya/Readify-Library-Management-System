<?php
require_once "../config.php"; //database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Readify Library Management System</title>

  <!-- Title icon -->
  <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

  <!-- ==== CSS Links ==== -->
  <link rel="stylesheet" href="../../css/custom_bootstrap.css">

  <!-- ==== Google Fonts Link ==== -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- ==== Boxicons link ==== -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

  <!-- ===== Bootstrap link ======== -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- ===== Bootstrap icon link ======== -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>

<body>

  <!-- Sidebar starts  -->
  <div id="mySidenav" class="sidenav">
    <div class="logo-container">
      <a href="../../pages/index.html">
        <img src="../../svg/logo-1.svg" alt="Readify Logo">
      </a>
    </div>

    <div class="links">
      <a href="./adminDashboard.php" class="sidebar-links"><i class='bx bxs-dashboard'></i> Dashboard</a>
      <a href="./viewBook.php" class="sidebar-links"><i class='bx bx-book-open' style='color:#ffffff'></i> View Books</a>
      
      <ul class="manage-books-menu">
        <li><a href="./Managebooks.php" class="sidebar-links"><i class='bx bx-library'></i> Manage Books</a></li>
        <li><a href="./Issued.php" class="sidebar-links"><i class='bx bxs-book-add'></i> Add New Book</a></li>
      </ul>

      <a href="./Request.php" class="sidebar-links"><i class='bx bx-list-check'></i> Approval Books List</a>
      <a href="./issue_info.php" class="sidebar-links"><i class='bx bx-list-ul'></i> Approved Books Log</a>
      <a href="./Expired.php" class="sidebar-links"><i class='bx bx-library'></i> Book Status</a>
      <a href="./fine.php" class="sidebar-links"><i class='bx bxs-wallet-alt'></i> Fine Info</a>
      <a href="./manageUser.php" class="sidebar-links"><i class='bx bxs-user-account'></i> Users Details</a>
      <a href="./admin-LogOut.php" class="sidebar-links"><i class="bx bx-log-out"></i> Log out</a>

    </div>
  </div>



</body>
</html>