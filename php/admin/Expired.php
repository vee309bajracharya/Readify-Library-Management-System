<?php
include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery
if (isset ($_SESSION['admin'])) {
    // SQL query to update the status of expired books
    $expireQuery = "UPDATE issue_book SET approve = '<p> Expired </p>' WHERE `return` < CURDATE() AND approve = 'Yes'";
    mysqli_query($conn, $expireQuery); // Execute the query to update expired books
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>
    <style>
        .requestBar__wrapper {
            margin-bottom: 10px;
        }

        .scroll {
            width: 100%;
            height: 500px;
            overflow: auto;
        }

        th,
        td {
            width: 10%;
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
            <a href="./manageUser.php"><i class='bx bxs-user-account'></i> Manage Users</a>
            <a href="./Expired.php"><i class='bx bxs-user-account'></i> Expired Date</a>
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

            <?php
            if (isset ($_SESSION['admin'])) {
                ?>
                <div class="searchBar__wrapper">
                    <h2> Request Book </h2>
                    <form action="" class="navbar-form-c" method="POST" name="form-1">
                        <div class="searchBar_field">
                            <input class="form-control-search" type="text" name="username" placeholder="Username"
                                style="width:100%" required>
                            <input type="text" name="book_id" class="form-control" placeholder="books_id" style="width:100%"
                                required>
                            <button type="submit" name="submit" class="btn-search">Search Book</button>
                        </div>
                    </form>
                </div>

                <form action="" method="POST"> <!-- Form for buttons -->
                    <button type="submit" name="submit1" class="btn btn-default">All Information</button>
                    <button type="submit" name="submit2" class="btn btn-default">Returned</button>
                    <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                </form>

                <?php

                if (isset ($_POST['submit'])) {
                    $var1 = '<p> Returned </p>';
                    $sql = "UPDATE issue_book SET approve='$var1' WHERE username='$_POST[username]' AND books_id='$_POST[book_id]'";
                    mysqli_query($conn, $sql);
                }

                if (isset ($_POST['submit1'])) {
                    $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name, library_books.authors, 
                    library_books.edition, issue_book.approve, issue_book.issue, issue_book.return                
                    FROM library_users INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id ORDER BY issue_book.return DESC";
                }

                if (isset ($_POST['submit2'])) {
                    $ret = '<p> Returned </p>';
                    $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name, library_books.authors, 
                    library_books.edition, issue_book.approve, issue_book.issue, issue_book.return                
                    FROM library_users INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id WHERE issue_book.approve = '$ret' ORDER BY issue_book.return DESC";
                }

                if (isset ($_POST['submit3'])) {
                    $exp = '<p> Expired </P>';
                    $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name, library_books.authors, 
                    library_books.edition, issue_book.approve, issue_book.issue, issue_book.return                
                    FROM library_users INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id WHERE issue_book.approve = '$exp' ORDER BY issue_book.return DESC";
                }

                // For default display
                if (!isset ($_POST['submit1']) && !isset ($_POST['submit2']) && !isset ($_POST['submit3'])) {
                    $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name,
                            library_books.authors, library_books.edition, issue_book.approve, issue_book.issue, issue_book.return                
                            FROM library_users 
                            INNER JOIN issue_book ON library_users.username = issue_book.username 
                            INNER JOIN library_books ON issue_book.books_id = library_books.books_id 
                            ORDER BY issue_book.return DESC";
                }


                $res = mysqli_query($conn, $sql);
                if ($res) {
                    // Query executed successfully
                    echo "<div class='scroll'>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    // Table headers
                    echo "<th>Student Username</th>";
                    echo "<th>User ID</th>";
                    echo "<th>Book ID</th>";
                    echo "<th>Books Name</th>";
                    echo "<th>Authors</th>";
                    echo "<th>Edition</th>";
                    echo "<th>Status</th>";
                    echo "<th>Issued Date</th>";
                    echo "<th>Return Date</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        // Fetch data from issue_book table
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row["user_id"] . "</td>";
                        echo "<td>" . $row['books_id'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td>" . $row['authors'] . "</td>";
                        echo "<td>" . $row['edition'] . "</td>";
                        echo "<td>" . $row['approve'] . "</td>";
                        echo "<td>" . $row['issue'] . "</td>";
                        echo "<td>" . $row['return'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    // Query failed
                    echo "Error: " . mysqli_error($conn);
                }

            } else {
                ?>
                <h3> Please login first </h3>
                <?php
            }
            ?>
        </div>
    </div>
</body>

</html>