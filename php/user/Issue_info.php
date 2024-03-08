<?php
include "./userNavbar.php";
require_once "../config.php"; 

$searchBarQuery = null; // Set a default value for $searchBarQuery

if (isset($_SESSION['user'])) {
    $searchBarQuery = mysqli_query($conn, "SELECT books_id, approve, issue, `return` FROM issue_book WHERE username='$_SESSION[user]'");
} else {
    echo "No user specified.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

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
        
        <?php
        if ($searchBarQuery) {
            if (mysqli_num_rows($searchBarQuery) == 0) {
                echo "There is no pending request";
            } else {
                echo "<div>";
                echo "<table class='table table-bordered table-hover'>";
                echo "<tr>";
                //Table header

                echo "<th>";echo "Book ID";echo "</th>";
                echo "<th>";echo "Approve Status";echo "</th>";
                echo "<th>";echo "Request Date";echo "</th>";
                echo "<th>";echo "Issued Date";echo "</th>";
                echo "<th>";echo "Return Date";echo "</th>";


                echo "</tr>";
                while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                    echo "<tr>";
                    //fetch data from issue_book table
                    echo "<td>" . $row['books_id'] . "</td>";
                    echo "<td>" . $row['approve'] . "</td>";
                    echo "<td>" . $row['issue'] . "</td>";
                    echo "<td>" . $row['return'] . "</td>";

                    echo "<td>";

                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "<br><br><br>";
            echo "<h2> Please log in first <h2>";
        }
        ?>
    </div>

</body>

</html>
