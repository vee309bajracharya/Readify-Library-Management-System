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
            <a href="#"><i class="ri-lock-password-fill"></i> Change Password</a>
            <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
            <a href="./issue_info.php"><i class='bx bxs-book'></i> View Issued Books</a>
            <a href="#"><i class='bx bxs-book'></i> View Archive Books</a>
            <a href="./Request.php"><i class='bx bxs-book'></i>Book Request</a>
            <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
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
        <br>
        <div class="searchBar__wrapper">
            <h2> Request Book </h2>
            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="username" placeholder="Username" style="width:100%" required>
                    <input type="text" name="book_id" class="form-control" placeholder="BID" style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Search Book</button>
                </div>
            </form>
        </div>
        <?php
if (isset($_SESSION['admin'])) {
    $sql = "SELECT 
                library_users.username, 
                user_id, 
                issue_book.books_id, 
                library_books.books_name, 
                library_books.authors, 
                library_books.edition, 
                library_books.status 
            FROM 
                library_users 
            INNER JOIN 
                issue_book ON library_users.username = issue_book.username 
            INNER JOIN 
                library_books ON issue_book.books_id = library_books.books_id 
            WHERE 
                issue_book.approve = ''";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 0) {
        echo "There is no pending request";
    } else {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        //Table header

        echo "<th>";
        echo "Student Username";
        echo "</th>";
        echo "<th>";
        echo "User ID";
        echo "</th>";
        echo "<th>";
        echo "Book ID";
        echo "</th>";
        echo "<th>";
        echo "Books Name";
        echo "</th>";
        echo "<th>";
        echo "Authors";
        echo "</th>";
        echo "<th>";
        echo "Edition";
        echo "</th>";
        echo "<th>";
        echo "Status";
        echo "</th>";

        echo "</tr>";
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            //fetch data from issue_book table
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "<td>" . $row['books_id'] . "</td>";
            echo "<td>" . $row['books_name'] . "</td>";
            echo "<td>" . $row['authors'] . "</td>";
            echo "<td>" . $row['edition'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
 
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
} else {
    ?> 
    <br> <br> <br>
    <h3> You need to login to see the request</h3>

    <?php
}
if(isset($_POST['submit'])){
    $_SESSION['st_name'] = $_POST['username'];
    $_SESSION['bid'] = $_POST['Book_id'];
    ?>
    <script>
        window.location="Approve.php"
    </script>
    <?php
}
?>
</div>
</body>

</html>