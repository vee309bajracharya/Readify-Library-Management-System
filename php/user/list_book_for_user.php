<?php
include "./userNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <style>
        .requestBar__wrapper{
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

        <!-- Search bar for books -->
        <div class="searchBar__wrapper">
    

            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="search" placeholder="Type Book Name" style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Search Book</button>
                </div>
            </form>
        </div>

        

        <!-- PHP code to display books -->
        <?php
        // Fetch book data from the database
        if (isset($_POST['submit'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
        } else {
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_name` ASC;");
        }
        

        if (mysqli_num_rows($searchBarQuery) == 0) {
            echo "<section>Book not Found</section>";
        } else {
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            //Table header
            echo "<th>";echo "Books ID";
            echo "</th>";
            echo "<th>";
            echo "Books Name";
            echo "</th>";
            echo "<th>";
            echo "Edition";
            echo "</th>";
            echo "<th>";
            echo "Authors";
            echo "</th>";
            echo "<th>";
            echo "Status";
            echo "</th>";
            echo "<th>";
            echo "Quantity";
            echo "</th>";
            echo "<th>";
            echo "Department";
            echo "</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                echo "<tr>";
                //fetch data from library_books table
                echo "<td>" . $row['books_id'] . "</td>";
                echo "<td>" . $row['books_name'] . "</td>";
                echo "<td>" . $row['edition'] . "</td>";
                echo "<td>" . $row['authors'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        ?>

    </div>
</body>
</html>
