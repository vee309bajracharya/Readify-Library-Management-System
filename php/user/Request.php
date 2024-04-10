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

                // if user has already requested this book
                $_SESSION['msg'] = "You have already requested this book";
                $_SESSION['msg_code'] = "error";
            } else {
                // User has not requested this book yet, proceed with insertion

                $query = "INSERT INTO issue_book (username, books_id, books_name) VALUES ('$username', '$books_id','$books_name')";

                if (mysqli_query($conn, $query)) {
                    echo "<script>
                        window.location='issue_info.php';
                    </script>";
                } else {
                    // Error message for database insertion error
                    echo "<script>alert('Error requesting book: " . mysqli_error($conn) . "');</script>";
                }
            }
        } else {
            // Error message for book not found
            $_SESSION['msg'] = "Book ID not found in the database";
            $_SESSION['msg_code'] = "error";
        }
    } else {
        // User not logged in message
        $_SESSION['msg'] = "You must log in first to request a book";
        $_SESSION['msg_code'] = "error";
    }
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

                <div class="searchBar_container">

                    <div class="requestBar__wrapper">

                        <form action="" class="navbar-form-c" method="POST" name="form-1">
                            <div class="searchBar_field">
                                <input class="form-control-search" type="text" name="books_id" placeholder="Enter book id" style="width:100%" required>
                                <button type="submit" name="request" class="btn-search">Request Book</button>
                            </div>
                        </form>
                    </div>

                    <div class="requestBar__wrapper">
                        <form action="" class="navbar-form-c" method="POST" name="form-1">
                            <div class="searchBar_field">
                                <input class="form-control-search" type="text" name="search" placeholder="Type Book Name" style="width:100%" required>
                                <button type="submit" name="submit" class="btn-search">Search Book</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>



            <!-- PHP code to display books and handle book request submission -->
            <?php
            // Fetch book data from the database
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
            } else {
                $searchBarQuery = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_id` ASC;");
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