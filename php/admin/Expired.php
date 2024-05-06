<?php
include "./adminNavbar.php";
require_once "../config.php";

// Update the status of expired books
if (isset($_SESSION['admin'])) {
    $expireQuery = "UPDATE issue_book SET approve = 'Expired' WHERE `return` < CURDATE() AND approve = 'Approved'";
    mysqli_query($conn, $expireQuery);
}

if (isset($_SESSION['admin'])) {
    // Update the status of books considered lost if their approval status is 'Approved'
    $bookLostQuery = "UPDATE issue_book 
    SET approve = 'Book Lost ' 
    WHERE (DATEDIFF(CURDATE(), `return`) > 30) AND (approve = 'Approved' OR approve = 'Expired')";
    mysqli_query($conn, $bookLostQuery);
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
    <?php include "./adminSidebar.php"; ?>

    <div class="list_container">
        <div id="main">
            <div class="container">

                <?php

                $approvedCountQuery = "SELECT COUNT(approve) AS approvedCount FROM issue_book WHERE approve = 'Approved'";
                $approvedCountResult = mysqli_query($conn, $approvedCountQuery);
                $approvedCountRow = mysqli_fetch_assoc($approvedCountResult);
                $approvedCount = $approvedCountRow['approvedCount'];


                $expireCountQuery_issue_book = "SELECT COUNT(approve) AS expireCount FROM issue_book WHERE approve = 'Expired'";
                $expireCountResult_issue_book = mysqli_query($conn, $expireCountQuery_issue_book);
                $expiredCountRow_issue_book = mysqli_fetch_assoc($expireCountResult_issue_book);
                $expiredCount_issue_book = $expiredCountRow_issue_book['expireCount'];

                $expireCountQuery_fine = "SELECT COUNT(book_status) AS expiredCount FROM fine WHERE book_status = 'Expired' AND fine > 0";
                $expireCountResult_fine = mysqli_query($conn, $expireCountQuery_fine);
                $expiredCountRow_fine = mysqli_fetch_assoc($expireCountResult_fine);
                $expiredCount_fine = $expiredCountRow_fine['expiredCount'];

                $totalExpiredCount = $expiredCount_issue_book + $expiredCount_fine;





                $BookLostCountQuery = "SELECT COUNT(approve) AS BookLostCount FROM issue_book WHERE approve = 'Book Lost '";
                $BookLostCountResult = mysqli_query($conn, $BookLostCountQuery);
                $BookLostCountRow = mysqli_fetch_assoc($BookLostCountResult);
                $BookLostCount = $BookLostCountRow['BookLostCount'];

                $BooklostountQuery_fine = "SELECT COUNT(book_status) AS BooklostCount FROM fine WHERE book_status = 'Book Lost' AND fine > 0";
                $BooklostountResult_fine = mysqli_query($conn, $BooklostountQuery_fine);
                $BooklostCountRow_fine = mysqli_fetch_assoc($BooklostountResult_fine);
                $BooklostCount_fine = $BooklostCountRow_fine['BooklostCount'];


                $totalBookLostCount = $BookLostCount + $BooklostCount_fine;

                echo "Approved Book's : {$approvedCount}";
                echo "Expired Book's : {$totalExpiredCount}";
                echo "Lost Book's : {$totalBookLostCount}";
                ?>

                <?php if (isset($_SESSION['admin'])): ?>
                    <div class="searchBar__wrapper">
                        <h2>Book Status </h2>
                        <script>
                            function checkBookLost() {
                                var checkboxes = document.getElementsByName('Returned_books_id[]');
                                for (var i = 0; i < checkboxes.length; i++) {
                                    var parts = checkboxes[i].value.split("_");
                                    var bookID = parts[0];
                                    var username = parts[1];
                                    // AJAX call to check if the book is marked as lost
                                    $.ajax({
                                        type: 'POST',
                                        url: 'check_book_lost.php', // Update this with the correct URL
                                        data: {
                                            bookID: bookID,
                                            username: username
                                        },
                                        success: function (response) {
                                            // If the book is marked as lost, check the checkbox
                                            if (response === 'lost') {
                                                checkboxes[i].checked = true;
                                            }
                                        }
                                    });
                                }
                            }
                        </script>

                        <?php
                        if (isset($_POST['markReturned']) && isset($_POST['Returned_books_id'])) {
                            foreach ($_POST['Returned_books_id'] as $Returned_book_id) {
                                // Split the returned book ID to extract username and book ID
                                list($books_id, $username) = explode("_", $Returned_book_id);

                                // Query to retrieve return date for the book
                                $returnDateQuery = "SELECT `return` FROM issue_book WHERE username ='$username' AND books_id ='$books_id' AND (approve = 'Expired' OR approve = 'Approved')";
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
                                        $fine = ($differenceInDays > 0) ? $differenceInDays * 40 : 0;

                                        // Update status to "Returned"
                                        $updateQuery = "UPDATE issue_book SET approve='Returned' WHERE username='$username' AND books_id='$books_id'";
                                        mysqli_query($conn, $updateQuery);

                                        // Insert fine details into fine table if there is a fine
                                        if ($fine > 0) {
                                            $insertFineQuery = "INSERT INTO fine (username, bid, returned, days, fine, status, book_status) VALUES ('$username', '$books_id', '$currentDate', '$differenceInDays', '$fine', 'unpaid', 'Expired')";
                                            mysqli_query($conn, $insertFineQuery);
                                        }

                                        // Retrieve user_id, book details, and other information
                                        $getUserIDQuery = "SELECT user_id FROM library_users WHERE username='$username'";
                                        $getUserIDResult = mysqli_query($conn, $getUserIDQuery);
                                        $row = mysqli_fetch_assoc($getUserIDResult);
                                        $user_id = $row['user_id'];

                                        $getBookDetailsQuery = "SELECT books_name, book_cover, authors, approve, issue,  `return`,requested FROM issue_book WHERE username='$username' AND books_id='$books_id'";
                                        $getBookDetailsResult = mysqli_query($conn, $getBookDetailsQuery);
                                        $bookDetailsRow = mysqli_fetch_assoc($getBookDetailsResult);
                                        $books_name = $bookDetailsRow['books_name'];
                                        $book_cover = $bookDetailsRow['book_cover'];
                                        $authors = $bookDetailsRow['authors'];
                                        $approve = $bookDetailsRow['approve'];
                                        $issue = $bookDetailsRow['issue'];
                                        $return = $bookDetailsRow['return'];
                                        $requested = $bookDetailsRow['requested'];

                                        // Insert returned book details into returned_book table
                                        $Markasreturneddate = date('Y-m-d');
                                        $insertReturnedBookQuery = "INSERT INTO returned_book (username, user_id, books_id, books_name, book_cover, authors, approve, issue, return_date, returned_date, requested) VALUES ('$username','$user_id', '$books_id', '$books_name', '$book_cover', '$authors', '$approve', '$issue','$return','$Markasreturneddate','$requested')";
                                        $insertReturnedBookResult = mysqli_query($conn, $insertReturnedBookQuery);

                                        if ($insertReturnedBookResult) {
                                            $deleteQuery = "DELETE FROM issue_book WHERE username='$username' AND books_id='$books_id' AND approve = 'Returned'";
                                            mysqli_query($conn, $deleteQuery);
                                        }
                                        // Output fine details
                                        echo '<div class="fine-details">';
                                        echo '<h2>Fine details:</h2>';
                                        echo '<p><span class="highlight">Username:</span> ' . $username . '</p>';
                                        echo '<p><span class="highlight">Book ID:</span> ' . $books_id . '</p>';
                                        echo '<p><span class="highlight">Return Date:</span> ' . $returnDate . '</p>';
                                        echo '<p><span class="highlight">Returned Date:</span> ' . $currentDate . '</p>';
                                        echo '<p><span class="highlight">Difference in Days:</span> ' . $differenceInDays . '</p>';
                                        echo '<p><span class="highlight">Fine:</span> रु ' . number_format($fine, 2) . '</p>';

                                        echo '</div>';
                                    } else {
                                        // Book is returned before the return date
                                        // Update status to "Returned" without charging any fine
                                        $updateQuery = "UPDATE issue_book SET approve='Returned' WHERE username='$username' AND books_id='$books_id' AND (approve = 'Approved' OR approve = 'Expired')";
                                        mysqli_query($conn, $updateQuery);
                                        // Retrieve user_id, book details, and other information
                                        $getUserIDQuery = "SELECT user_id FROM library_users WHERE username='$username'";
                                        $getUserIDResult = mysqli_query($conn, $getUserIDQuery);
                                        $row = mysqli_fetch_assoc($getUserIDResult);
                                        $user_id = $row['user_id'];

                                        $getbookInfoQuery = "SELECT book_cover, authors FROM library_books WHERE books_id='$books_id'";
                                        $getbookInfoResult = mysqli_query($conn, $getbookInfoQuery);
                                        $getbookInfoRow = mysqli_fetch_assoc($getbookInfoResult);
                                        $book_cover = $getbookInfoRow['book_cover'];
                                        $authors = $getbookInfoRow['authors'];


                                        $getBookDetailsQuery = "SELECT books_name, approve, issue, `return`, requested FROM issue_book WHERE username='$username' AND books_id='$books_id'";
                                        $getBookDetailsResult = mysqli_query($conn, $getBookDetailsQuery);
                                        $bookDetailsRow = mysqli_fetch_assoc($getBookDetailsResult);
                                        $books_name = $bookDetailsRow['books_name'];
                                        $approve = $bookDetailsRow['approve'];
                                        $issue = $bookDetailsRow['issue'];
                                        $return = $bookDetailsRow['return'];
                                        $requested = $bookDetailsRow['requested'];


                                        // Insert returned book details into returned_book table
                                        $Markasreturneddate = date('Y-m-d');

                                        echo '<div class="details">';
                                        echo '<h2>Book Return Details:</h2>';
                                        echo '<p><span class="highlight">Username:</span> ' . $username . '</p>';
                                        echo '<p><span class="highlight">Book ID:</span> ' . $books_id . '</p>';
                                        echo '<p style="color:green";> No fine Charged </p>';
                                        echo '</div>';

                                        $insertReturnedBookQuery = "INSERT INTO returned_book (username, user_id, books_id, books_name, book_cover, authors, approve, issue, return_date, returned_date, requested) VALUES ('$username','$user_id', '$books_id', '$books_name', '$book_cover', '$authors', '$approve', '$issue','$return','$Markasreturneddate','$requested')";
                                        mysqli_query($conn, $insertReturnedBookQuery);


                                        // Output message indicating book returned before return date
                                        $_SESSION['msg'] = "Book returned before the return date. No fine charged";


                                        $deleteQuery = "DELETE FROM issue_book WHERE username='$username' AND books_id='$books_id' AND approve = 'Returned'";
                                        mysqli_query($conn, $deleteQuery);


                                    }
                                } else {
                                    // No record found for the given username and book ID
                                    $updateQuery = "UPDATE issue_book SET approve='Returned' WHERE username='$username' AND books_id='$books_id' AND (approve = 'Approved' OR approve = 'Expired')";
                                    mysqli_query($conn, $updateQuery);

                                    $_SESSION['msg'] = "Book returned before the return date. No fine charged";
                                    $_SESSION['msg_code'] = "error";
                                }
                            }
                        }


                        ?>
                        <?php

                        if (isset($_POST['markLost'])) {
                            // Retrieve all books_id marked as lost
                            $lostBooksQuery = "SELECT books_id, username, `return` FROM issue_book WHERE approve = 'Book Lost '";
                            $lostBooksResult = mysqli_query($conn, $lostBooksQuery);
                            if ($lostBooksResult) {
                                while ($row = mysqli_fetch_assoc($lostBooksResult)) {
                                    $books_id = $row['books_id'];
                                    $username = $row['username'];
                                    $returnDate = $row['return']; // Set return date here
                    
                                    // Perform necessary actions for each lost book
                                    $lostBookFine = 0;
                                    $lostCurrentDate = date('Y-m-d');
                                    $differenceInDays = ceil((strtotime($lostCurrentDate) - strtotime($returnDate)) / (60 * 60 * 24));
                                    if ($differenceInDays >= 0) {
                                        $lostBookFine = ($differenceInDays > 0) ? 5000 : 0;
                                        $insertFineQuery = "INSERT INTO fine (username, bid, returned, days, fine, status, book_status) VALUES ('$username', '$books_id', '$lostCurrentDate', '$differenceInDays', '$lostBookFine', 'unpaid', 'Book Lost')";
                                        mysqli_query($conn, $insertFineQuery);
                                        $deleteLostQuery = "DELETE FROM issue_book WHERE books_id = '$books_id' AND username = '$username'";
                                        mysqli_query($conn, $deleteLostQuery);
                                    } else {
                                        echo "No books are lost";
                                    }
                                }
                            }

                        }
                        ?>
                        <form action="" method="POST">
                            <button type="submit" name="markReturned" class="btn btn-default">Mark as Returned</button>


                            <button type="submit" name="markLost" onclick="checkBooklost()" class="btn btn-default">Declare
                                Lost</button>

                            <!-- Filter buttons -->
                            <button type="submit" name="submit1" class="btn btn-default">All Info</button>
                            <button type="submit" name="submit4" class="btn btn-default">Approved</button>
                            <button type="submit" name="submit2" class="btn btn-default">Returned</button>
                            <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                            <?php

                            // Default SQL query
                            $sql = "SELECT 
                                    library_users.username,
                                    library_users.user_id,
                                    issue_book.books_id,
                                    library_books.books_name,
                                    library_books.book_cover,
                                    library_books.authors,
                                    issue_book.approve,
                                    issue_book.issue,
                                    issue_book.return,
                                    issue_book.returned
                                FROM library_users 
                                INNER JOIN issue_book ON library_users.username = issue_book.username 
                                INNER JOIN library_books ON issue_book.books_id = library_books.books_id
                                ORDER BY issue_book.return DESC";

                            // Handle filter button actions
                            if (isset($_POST['submit1'])) {
                                $sql = "SELECT 
                                        library_users.username,
                                        library_users.user_id,
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
                             
                                    ORDER BY issue_book.return DESC";
                            }

                            if (isset($_POST['submit2'])) {
                                $sql = "SELECT 
                                        library_users.username,
                                        library_users.user_id,
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
                                    WHERE issue_book.approve LIKE '%Returned%'
                                    ORDER BY issue_book.return DESC";
                            }

                            if (isset($_POST['submit3'])) {
                                $sql = "SELECT 
                                        library_users.username,
                                        library_users.user_id,
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
                                    WHERE issue_book.approve LIKE '%Expired%'
                                    ORDER BY issue_book.return DESC";
                            }

                            if (isset($_POST['submit4'])) {
                                $sql = "SELECT 
                                        library_users.username,
                                        library_users.user_id,
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
                                    WHERE issue_book.approve LIKE '%Approved%'
                                    ORDER BY issue_book.return DESC";
                            }

                            // Execute the SQL query
                            $res = mysqli_query($conn, $sql);

                            // Display the results in a table
                            if ($res) {
                                echo "<div class='scroll'>";
                                echo "<table class='table table-bordered table-hover'>";
                                echo "<tr>";
                                echo "<th>Action</th>";
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
                                    echo "<td>";
                                    echo "<input type='checkbox' name='Returned_books_id[]' value='" . $row['books_id'] . "_" . $row['username'] . "' id='returnedCheckbox' class='btn bg-info text-bg-info'></input>
                                            ";
                                    echo "</td>";
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
                                echo "Error: " . mysqli_error($conn);
                            }
                            ?>
                        </form>
                    </div>
                <?php else: ?>
                    <h3>Please login first</h3>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>



    <?php
    include ('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>