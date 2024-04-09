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
    <!-- include Sidebar -->
    <?php
        include "./adminSidebar.php";
    ?>

    <div class="list_container">
        <div id="main">
            <div class="container">

                <?php
                if (isset ($_SESSION['admin'])) {
                    ?>
                    <div class="searchBar__wrapper">
                        <h2>Book Status </h2>

                                <!-- Form for username search -->
                                <form action="" class="navbar-form-c" method="POST" name="form-1">
                                    <div class="searchBar_field">
                                        <input class="form-control-search" type="text" name="username"
                                            placeholder="Username" style="width:100%" required>
                                        <input type="text" name="book_id" class="form-control-search" placeholder="books_id"
                                            style="width:100%" required>

                                        <button type="submit" name="submit" class="btn-search">Mark as Returned</button>
                                    </div>
                                </form>

                    </div>

                    <!-- Form for filter buttons -->
                    <div style='margin-top:2rem;'>
                    <form action="" method="POST">
                        <button type="submit" name="submit1" class="btn btn-default">All Information</button>
                        <button type="submit" name="submit2" class="btn btn-default">Returned</button>
                        <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                    </form>
                    </div>


                    <?php

                    if (isset ($_POST['submit'])) {

                        if (isset ($_POST['username']) && isset ($_POST['book_id'])) {
                            // Fetch username and book ID from the form
                            $username = $_POST['username'];
                            $books_id = $_POST['book_id'];
                            $fine = 0;

                            // Query to retrieve return date for the book
                            $returnDateQuery = "SELECT `return` FROM issue_book WHERE username ='$username' AND books_id ='$books_id' AND approve = '<p> Expired </p>'";
                            $returnDateResult = mysqli_query($conn, $returnDateQuery);
                            $returnDateRow = mysqli_fetch_assoc($returnDateResult);

                            // Calculate difference in days between current date and return date
                            $returnDate = date('Y-m-d', strtotime($returnDateRow['return']));
                            $currentDate = date('Y-m-d');
                            $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));

                            // Calculate fine if book is returned after the return date
                            if ($differenceInDays > 0) {
                                $fine = $differenceInDays * 40;

                                // Update status to "Returned" and insert fine details into fine table
                                $updateQuery = "UPDATE issue_book SET approve='<p> Returned </p>' WHERE username='$username' AND books_id='$books_id'";
                                mysqli_query($conn, $updateQuery);

                                // Insert fine details into fine table
                                $insertFineQuery = "INSERT INTO fine (username, bid, returned, days, fine, status) VALUES ('$username', '$books_id', '$currentDate', '$differenceInDays', '$fine', 'unpaid')";
                                mysqli_query($conn, $insertFineQuery);
                            }

                            // Output fine details
                            echo "Fine details:<br>";
                            echo "Username: $username<br>";
                            echo "Book ID: $books_id<br>";
                            echo "Return Date: $returnDate<br>";
                            echo "Current Date: $currentDate<br>";
                            echo "Difference in Days: $differenceInDays<br>";
                            echo "Fine: रु " . number_format($fine, 2);
                        } else {
                            // Form fields not filled properly
                            echo "Error: Please fill in all the fields.";
                        }
                    }

                    // Handle filter button actions
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

                    // Default display if no filter is selected
                    if (!isset ($_POST['submit1']) && !isset ($_POST['submit2']) && !isset ($_POST['submit3'])) {
                        $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name,
                            library_books.authors, library_books.edition, issue_book.approve, issue_book.issue, issue_book.return                
                            FROM library_users 
                            INNER JOIN issue_book ON library_users.username = issue_book.username 
                            INNER JOIN library_books ON issue_book.books_id = library_books.books_id 
                            ORDER BY issue_book.return DESC";
                    }

                    // Execute SQL query
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
                        echo "<th>Book Issued Date</th>";
                        echo "<th>Book Return Date</th>";
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
                    <h3>Please login first</h3>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>