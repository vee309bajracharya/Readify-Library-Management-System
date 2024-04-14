<?php
include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery
if (isset($_SESSION['admin'])) {
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
                if (isset($_SESSION['admin'])) {
                ?>
                    <div class="searchBar__wrapper">




                        <h2>Book Status </h2>

                        <!-- Form for username search -->
                        <form action="" class="navbar-form-c" method="POST" name="form-1">
                            <div class="searchBar_field">
                                <input class="form-control-search" type="text" name="username" placeholder="Username" style="width:100%" required>
                                <input type="text" name="book_id" class="form-control-search" placeholder="books_id" style="width:100%" required>

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

                    if (isset($_POST['submit'])) {

                        if (isset($_POST['username']) && isset($_POST['book_id'])) {
                            // Fetch username and book ID from the form
                            $username = $_POST['username'];
                            $books_id = $_POST['book_id'];
                            $fine = 0;

                            // Query to retrieve return date for the book
                            $returnDateQuery = "SELECT `return` FROM issue_book WHERE username ='$username' AND books_id ='$books_id' AND approve = '<p> Expired </p>'";
                            $returnDateResult = mysqli_query($conn, $returnDateQuery);

                            if ($returnDateResult && mysqli_num_rows($returnDateResult) > 0) {
                                $returnDateRow = mysqli_fetch_assoc($returnDateResult);
                                $returnDate = $returnDateRow['return'];

                                // Calculate difference in days between current date and return date
                                $currentDate = date('Y-m-d');
                                $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));

                                // Check if the book is returned before the return date
                                if ($differenceInDays >= 0) {
                                    // Book is returned after or on the return date
                                    // Calculate fine if book is returned after the return date
                                    if ($differenceInDays > 0) {
                                        $fine = $differenceInDays * 40;
                                    }

                                    // Update status to "Returned"
                                    $updateQuery = "UPDATE issue_book SET approve='<p> Returned </p>' WHERE username='$username' AND books_id='$books_id'";
                                    mysqli_query($conn, $updateQuery);

                                    // Insert fine details into fine table if there is a fine
                                    if ($fine > 0) {
                                        $insertFineQuery = "INSERT INTO fine (username, bid, returned, days, fine, status) VALUES ('$username', '$books_id', '$currentDate', '$differenceInDays', '$fine', 'unpaid')";
                                        mysqli_query($conn, $insertFineQuery);
                                    }

                                    // Output fine details
                                    echo '<div class="fine-details">';
                                    echo '<h2>Fine details:</h2>';
                                    echo '<p><span class="highlight">Username:</span> ' . $username . '</p>';
                                    echo '<p><span class="highlight">Book ID:</span> ' . $books_id . '</p>';
                                    echo '<p><span class="highlight">Return Date:</span> ' . $returnDate . '</p>';
                                    echo '<p><span class="highlight">Current Date:</span> ' . $currentDate . '</p>';
                                    echo '<p><span class="highlight">Difference in Days:</span> ' . $differenceInDays . '</p>';
                                    echo '<p><span class="highlight">Fine:</span> रु ' . number_format($fine, 2) . '</p>';
                                    echo '</div>';
                                } else {
                                    // Book is returned before the return date
                                    // Update status to "Returned" without charging any fine
                                    $updateQuery = "UPDATE issue_book SET approve='<p> Returned </p>' WHERE username='$username' AND books_id='$books_id'";
                                    mysqli_query($conn, $updateQuery);

                                    // Output message indicating book returned before return date
                                    $_SESSION['msg'] = "Book returned before the return date. No fine charged";
                                }
                            } else {
                                // No record found for the given username and book ID
                                $updateQuery = "UPDATE issue_book SET approve='<p> Returned </p>' WHERE username='$username' AND books_id='$books_id'";
                                mysqli_query($conn, $updateQuery);
                                $_SESSION['msg'] = "Book returned before the return date. No fine charged";
                            }
                        } else {
                            $_SESSION['msg'] = "Please fill in all the fields";
                            $_SESSION['msg_code'] = "error";
                        }
                    }



                    // Handle filter button actions
                    if (isset($_POST['submit1'])) {
                        $sql = "SELECT 
                        library_users.username,
                        user_id,
                        issue_book.books_id,
                        library_books.books_name,
                        library_books.book_cover,
                        library_books.authors, 
                        issue_book.approve,
                        issue_book.issue,
                        issue_book.return                
                    FROM library_users 
                    INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id
                    WHERE NOT (issue_book.approve = '' OR issue_book.approve = 'No')
                    ORDER BY issue_book.return DESC";
                    }

                    if (isset($_POST['submit2'])) {
                        $ret = '<p> Returned </p>';
                        $sql = "SELECT 
                        library_users.username,
                        user_id,
                        issue_book.books_id,
                        library_books.books_name,
                        library_books.book_cover,
                        library_books.authors, 
                        issue_book.approve,
                        issue_book.issue,
                        issue_book.return                
                    FROM library_users 
                    INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id 
                    WHERE issue_book.approve = '$ret' OR (issue_book.approve = '' AND issue_book.approve LIKE '%NO%')
                    ORDER BY issue_book.return DESC";
                    }

                    if (isset($_POST['submit3'])) {
                        $exp = '<p> Expired </P>';
                        $sql = "SELECT 
                        library_users.username,
                        user_id,
                        issue_book.books_id,
                        library_books.books_name,
                        library_books.book_cover,
                        library_books.authors, 
                        library_books.edition,
                        issue_book.approve,
                        issue_book.issue,
                        issue_book.return                
                    FROM library_users 
                    INNER JOIN issue_book ON library_users.username = issue_book.username 
                    INNER JOIN library_books ON issue_book.books_id = library_books.books_id 
                    WHERE issue_book.approve = '$exp' OR (issue_book.approve = '' AND issue_book.approve LIKE '%NO%')
                    ORDER BY issue_book.return DESC";
                    }

                    // Default display if no filter is selected
                    if (!isset($_POST['submit1']) && !isset($_POST['submit2']) && !isset($_POST['submit3'])) {
                        $sql = "SELECT 
                        library_users.username,
                        user_id,
                        issue_book.books_id,
                        library_books.books_name,
                        library_books.book_cover,
                        library_books.authors,
                        issue_book.approve,
                        issue_book.issue,
                        issue_book.return                
                            FROM library_users 
                            INNER JOIN issue_book ON library_users.username = issue_book.username 
                            INNER JOIN library_books ON issue_book.books_id = library_books.books_id 
                            WHERE NOT (issue_book.approve = '' OR issue_book.approve = 'No')
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
                        echo "<th>Book Cover</th>";
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
                            echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
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


    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
    include('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>