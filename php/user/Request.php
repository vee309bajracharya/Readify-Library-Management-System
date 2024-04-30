<?php
include "./userNavbar.php";
require_once "../config.php";


// Check if the request form is submitted
if (isset($_POST['request'])) {

    // Check if user is logged in
    if (isset($_SESSION['user'])) {

        // Get the book ID from the form
        $books_id = mysqli_real_escape_string($conn, $_POST['books_id']);

        // Check if the book ID exists in the database
        $check_query = "SELECT * FROM library_books WHERE books_id = '$books_id'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            // Book exists in the database, proceed with insertion

            // Check if the user has already requested this book
            $books_name_query = "SELECT * FROM library_books WHERE books_id = '$books_id'";
            $books_name_result = mysqli_query($conn, $books_name_query);
            $book_row = mysqli_fetch_assoc($books_name_result);
            $books_name = $book_row['books_name'];

            $username = mysqli_real_escape_string($conn, $_SESSION['user']);
            $existing_request_query = "SELECT * FROM issue_book WHERE username = '$username' AND books_id = '$books_id'";
            $existing_request_result = mysqli_query($conn, $existing_request_query);

            if (mysqli_num_rows($existing_request_result) > 0) {

            } else {
                //proceed with insertion
                $query = "INSERT INTO issue_book (username, books_id, books_name) VALUES ('$username', '$books_id','$books_name')";

                if (mysqli_query($conn, $query)) {
                    // Set session variables for success message
                    $_SESSION['msg'] = "Book Request Success!!";
                    $_SESSION['msg_code'] = "success";
                }
            }
        }
    } else {
        // User not logged in message
        $_SESSION['msg'] = "You must log in first to request a book";
        $_SESSION['msg_code'] = "error";
    }
}

if (isset($_GET['cancel_books_id'])) {
    // Get the book ID and username from the URL
    $cancel_books_id = mysqli_real_escape_string($conn, $_GET['cancel_books_id']);
    $cancel_username = mysqli_real_escape_string($conn, $_SESSION['user']);

    // Delete the entry from the issue_book table
    $cancel_query = "DELETE FROM issue_book WHERE username = '$cancel_username' AND books_id = '$cancel_books_id'";
    if (mysqli_query($conn, $cancel_query)) {
        // Set session variables for success message
        $_SESSION['msg'] = "Book request cancelled successfully";
        $_SESSION['msg_code'] = "success";
    } else {
        $_SESSION['msg'] = "Error cancelling book request";
        $_SESSION['msg_code'] = "error";
    }

    // Redirect to the same page to remove the cancel_books_id parameter from the URL
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Book</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

</head>

<body>
    <!-- include Dashboard -->
    <?php
        include "./userDashboard.php";
    ?>

    <div class="list_container">
        <div id="main">

            <!-- Search bar for books -->
            <div class="searchBar__wrapper">
                <h3>Book Request</h3>
                    <div class="requestBar__wrapper">
                            <form action="" class="navbar-form-c" method="POST" name="form-1">
                                <div class="searchBar_field">
                                    <input class="form-control-search" type="text" name="search"
                                        placeholder="Type Book Name" style="width:100%" required>
                                    <button type="submit" name="submit" class="btn-search">Search Book</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>

            <!-- display books and handle book request submission -->
            <?php

            if (isset($_POST['request_filter'])) {
            }
            // Fetch book data from the database
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
            } else {
                $searchBarQuery = mysqli_query($conn, "SELECT * FROM `library_books` WHERE quantity > 0 ORDER BY `library_books`.`books_id` ASC;");
            }

            if (mysqli_num_rows($searchBarQuery) == 0) {
                echo "<section>";
                echo "<div class='error_container'>";
                echo "<img src='../../images/book_not_found.png' alt='Book Not Found' id='notFound'>";
                echo "</div>";
                echo "</section>";
            } else {
                echo "<div>";
                echo "<table class='table table-bordered table-hover'>";
                echo "<tr>";
                //Table header
                echo "<th>";echo "Books ID";echo "</th>";
                echo "<th>";echo "Books Name";echo "</th>";
                echo "<th>";echo "Book Cover";echo "</th>";
                echo "<th>";echo "Edition";echo "</th>";
                echo "<th>";echo "Authors";echo "</th>";
                echo "<th>";echo "Department";echo "</th>";
                echo "<th>";echo "Action";echo "</th>";
                echo "</tr>";

                while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                    echo "<tr>";
                    //fetch data from library_books table
                    echo "<td>" . $row['books_id'] . "</td>";
                    echo "<td>" . $row['books_name'] . "</td>";
                    echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                    echo "<td>" . $row['edition'] . "</td>";
                    echo "<td>" . $row['authors'] . "</td>";
                    echo "<td>" . $row['department'] . "</td>";
                    echo "<td>";
                    if (isset($_SESSION['user'])) {
                        // Check if the user has already requested this book
                        $username = mysqli_real_escape_string($conn, $_SESSION['user']);
                        $books_id = $row['books_id'];
                        $existing_request_query = "SELECT * FROM issue_book WHERE username = '$username' AND books_id = '$books_id'";
                        $existing_request_result = mysqli_query($conn, $existing_request_query);

                        if ($existing_request_result && mysqli_num_rows($existing_request_result) > 0) {
                            // Book is already requested by the user
                            echo "<form id='cancelForm' action='' method='POST'>";
                            echo "<a href='?cancel_books_id=" . $row['books_id'] . "' class='btn btn-action btn-cancel'>Cancel</a>";
                            echo "</form>";
                        } else {
                            // Check if the user has already requested 5 books
                            $existing_requests_query = "SELECT COUNT(*) AS total_requests FROM issue_book WHERE username = '$username'";
                            $existing_requests_result = mysqli_query($conn, $existing_requests_query);
                            $row_requests = mysqli_fetch_assoc($existing_requests_result);
                            $total_requests = $row_requests['total_requests'];

                            if ($total_requests >= 5) {
                                // User has already requested 5 books
                                echo "<form id='informForm' action='' method='POST' class='ml-3'>";
                                echo "<button class='btn btn-action' type='submit' name='inform'><i class='bx bx-info-circle'></i></button>";
                                echo "</form>";

                                if (isset($_POST['inform'])) {
                                        $_SESSION['msg'] = "Only 5 books are allowed to be requested";
                                        $_SESSION['msg_code'] = "error";
                                }
                            } else {
                                // Render the request button
                                echo "<form action='' method='POST'>";
                                echo "<input type='hidden' name='books_id' value='" . $row['books_id'] . "'>";
                                echo "<button type='submit' name='request' class='btn btn-action'>Request</button>";
                                echo "</form>";
                            }
                        }
                    } else {
                        // User not logged in
                        $_SESSION['msg'] = "Login to request a book";
                        $_SESSION['msg_code'] = "error";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php 
        include ('../sweetAlert/sweetalert_actions.php');
    ?>
</body>
</html>