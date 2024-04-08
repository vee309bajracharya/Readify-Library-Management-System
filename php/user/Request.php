<?php
include "./userNavbar.php";
require_once "../config.php";

// Check if the request form is submitted
if (isset ($_POST['request'])) {

    // Check if user is logged in
    if (isset ($_SESSION['user'])) {

        // Get the book ID from the form
        $books_id = mysqli_real_escape_string($conn, $_POST['books_id']);

        // Check if the book ID exists in the database
        $check_query = "SELECT * FROM library_books WHERE books_id = '$books_id'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            // Book exists in the database, proceed with insertion

            // Check if the user has already requested this book
            $username = mysqli_real_escape_string($conn, $_SESSION['user']);
            $existing_request_query = "SELECT * FROM issue_book WHERE username = '$username' AND books_id = '$books_id'";
            $existing_request_result = mysqli_query($conn, $existing_request_query);

            if (mysqli_num_rows($existing_request_result) > 0) {
                // User has already requested this book
                echo "<script>alert('You have already requested this book');</script>";
            } else {
                // User has not requested this book yet, proceed with insertion
                $books_name = mysqli_real_escape_string($conn, $_POST['books_name']);

                $query = "INSERT INTO issue_book (username, books_id, books_name) VALUES ('$username', '$books_id','$books_name')";

                if (mysqli_query($conn, $query)) {
                    // Success message
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
            echo "<script>alert('Book ID not found in the database');</script>";
        }
    } else {
        // User not logged in message
        echo "<script>alert('You must log in first to request a book');</script>";
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
                                <input class="form-control-search" type="text" name="books_id"
                                    placeholder="Enter book id" style="width:100%" required>
                                <button type="submit" name="request" class="btn-search">Request Book</button>
                            </div>
                        </form>
                    </div>

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



            <!-- PHP code to display books and handle book request submission -->
            <?php
            // Fetch book data from the database
            if (isset ($_POST['submit'])) {
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

</body>

</html>