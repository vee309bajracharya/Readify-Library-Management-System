<?php
require_once "../config.php";
include "./userNavbar.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">


    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- ==== Inline CSS ==== -->


    <style>
        .profile__wrapper {
            text-align: center;
            width: 70%;
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>

</head>

<body>

    <!-- ====== Sidebar ======== -->
    <div id="mySidenav" class="sidenav">
        <div class="logo-container">
            <a href="./list_book_for_user.php">
                <img src="../../svg/logo-1.svg" alt="">
            </a>
        </div>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


        <!-- Profile preview -->
        <div style="margin-top:1.4rem; margin-bottom: 2rem;" class="d-flex flex-column align-items-center text-center">
            <?php
            echo '<div class="custom-links">';
            echo '<img class="img-circle profile_img" width="80" height="80" src="./images/' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover; margin-top:1.3rem;">';
            echo "Welcome," . $_SESSION['user'];
            echo '</div>';
            ?>
        </div>

        <div class="links">
            <a href="./list_book_for_user.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
            <a href="./change_password.php"><i class="ri-lock-password-fill"></i> Change Password</a>
            <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
            <a href="./issue_info.php"><i class='bx bxs-book'></i> View Issued Books</a>
            <a href="#"><i class='bx bxs-book'></i> View Archive Books</a>
            <a href="./Request.php"><i class='bx bxs-book'></i>Book Request</a>
            <a href="./about_readify.php"><i class='bx bxs-help-circle'></i> About Readify</a>
            <a href="./logOut.php"><i class="bx bx-log-out"></i> Log out</a>
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

        <!-- ==== Sidebar ends here ===== -->

        <div class="profile__wrapper">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM library_users WHERE username = '$_SESSION[user]';");

            if (!$query) {
                die(mysqli_error($conn)); // Print any error message
            }

            // Check if any rows are returned
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);

                echo "<div class='row'>";
                echo "<div class='col-md-4'>";
                echo "<img class='img-thumbnail' width='300' height='300' src='./images/" . $_SESSION['pic'] . "'>";
                echo "</div>";

                echo "<div class='col-md-8'>";
                echo "<h4><b>Welcome, </b>" . $_SESSION['user'] . "</h4>";

                echo "<table class='table table-bordered'>";
                echo "<tr>";
                echo "<th scope='row'  class='custom-th'>Full Name</th>";
                echo "<td>" . $row['fullname'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row'  class='custom-th'>Username</th>";
                echo "<td>" . $row['username'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row' class='custom-th'>Email</th>";
                echo "<td>" . $row['email'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row' class='custom-th'>Phone Number</th>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row' class='custom-th'>Address</th>";
                echo "<td>" . $row['address'] . "</td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row' class='custom-th'>Library Card Number</th>";
                echo "<td>" . $row['library_card_number'] . "</td>";
                echo "</tr>";

                echo "</table>";

                // Edit button
                echo "<div class='text-center'>";
                echo "<form action='./myProfileEdit.php' method='post'>";
                echo "<a href='./myProfileEdit.php' class='btn btn-search' name='submit1' style='width: 30%; padding: 10px 15px; margin-top: 10px;'>";
                echo "<i class='bx bx-edit'></i> Edit Profile";
                echo "</a>";
                echo "</form>";
                echo "</div>";


                echo "</div>";
                echo "</div>";
            } else {
                echo "No user found with the specified username.";
            }
            ?>
        </div>


        <!-- === Bootstrap JavaScript Link==== -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </div>
</body>

</html>