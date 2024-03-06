<?php
include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>
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
    <style>
        .requestBar__wrapper {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
 <!-- Sidebar -->
 <div id="mySidenav" class="sidenav">
        <div class="logo-container">
            <a href="./list_book_for_user.php">
                <img src="../../svg/logo-1.svg" alt="Readify Logo">
            </a>
        </div>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


        

        <div class="links">
        <a href="./adminDashboard.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <a href="./Request.php"><i class='bx bxs-dashboard'></i> Manage Request</a>
        <a href="./Issued.php"><i class='bx bxs-book-add'></i> Add Books</a>
        <a href="./Managebooks.php"><i class='bx bxs-folder-open'></i> Manage Books</a>
        <a href="#"><i class='bx bx-money-withdraw'></i> Fine Collected</a>
        <a href="./manageUser.php"><i class='bx bxs-user-account' ></i> Manage Users</a>
        <a href="./admin-LogOut.php"><i class="bx bx-log-out"></i> Log out</a>

        </div>

    </div>

    <div id="main">
        <!-- JavaScript for sidebar -->
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "300px";
                document.getElementById("main").style.marginLeft = "300px";
                document.body.style.backgroundColor = "white";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.body.style.backgroundColor = "white";
            }
        </script>
            <div class="container">
            <h2>Information of Borrowed Books</h2>
            <?php

            ?>
            </div>
        <body>
            </html>