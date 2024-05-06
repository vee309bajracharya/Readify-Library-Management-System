<?php
include "./userNavbar.php";
require_once "../config.php";
include "./fineinfo.php"; // logic for expired books
include "./finedbooks.php"; // logic for total fines
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Status</title>

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
            <h3>Book Status</h3>
            
            <div class="count-amount-container d-flex justify-content-between gap-2">
                    <div class="count-info-list">
                        <h3 class="fs-3">Expired Books: <?php echo $expiredBooksCount; ?></h3> <br>
                        <span>NRS <?php echo $expiredFineCharged; ?> Charged</span>
                    </div>

                    <div class="count-info-list d-flex justify-content-between">
                        <div>
                            <h3 class="fs-3">Fined Books: <?php echo $finedBooksCount; ?></h3> <br>
                            <span>NRS <?php echo $totalFineCharged; ?> Charged</span>
                        </div>
                        <div class="link-fine">
                            <a href="./fine.php" class="btn-fine p-4 fw-bold">View Details</a>
                        </div>
                    </div>
            </div>
            <!-- <div class="my-5">


                <span>Check for detailed fines
                    <a href="./fine.php" class="fine-link">Here</a>
                </span><br>
                <span>Books returned delayed will be charged <span style="color:red;  font-weight:bold;"> रु॰
                        40</span>
                    per day.</span>
            </div> -->
            <h3>
                    <?php
                    // Query to count expired books
                    // $expiredCountQuery = "SELECT COUNT(approve) AS expiredCount FROM issue_book WHERE approve = 'Expired' AND username ='" . $_SESSION["user"] . "'";
                    // $expiredCountResult = mysqli_query($conn, $expiredCountQuery);
                    // $expiredCountRow = mysqli_fetch_assoc($expiredCountResult);
                    // $expiredCount = $expiredCountRow['expiredCount'];

                    // // Query to count fined books for the current user
                    // $expireCountQuery_fine = "SELECT COUNT(book_status) AS fineBookCount FROM fine WHERE book_status = 'Expired' AND fine > 0 AND username = '" . $_SESSION['user'] . "'";
                    // $fineBookCountResult = mysqli_query($conn, $expireCountQuery_fine);
                    // $fineBookCountRow = mysqli_fetch_assoc($fineBookCountResult);
                    // $fineBookCount = $fineBookCountRow['fineBookCount'];

                    // echo "Expired Book's : {$expiredBooksCount} | Fine रु॰{$fineinfo}<br>";
                    // echo "Fined Book's : {$finedBookdCount} | Fine रु॰{$fine} ";

                    ?>

                </h3>
            <?php


            // Set a default value for $searchBarQuery
            $searchBarQuery = null;

            // Check if the user is logged in
            if (isset($_SESSION['user'])) {
                // Retrieve the username of the logged-in user
                $loggedInUsername = $_SESSION['user'];

                // SQL query to retrieve information for the logged-in user
                //All information
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
                        WHERE library_users.username = '{$_SESSION['user']}'
                        ORDER BY issue_book.return DESC";

                // Execute the SQL query
                $res = mysqli_query($conn, $sql);

                if ($res) {
                    // Display the form for buttons
                    echo '
                    <form action="" method="POST" class="my-4"> 
                        <button type="submit" name="submit1" class="btn btn-default">All Information</button>
                        <button type="submit" name="submit2" class="btn btn-default">Returned</button>
                        <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                    </form>
                ';

                    if (isset($_POST['submit1'])) {
                        // Display all information for the logged-in user

                    } elseif (isset($_POST['submit2'])) {
                        //Returned
                        $ret = 'Returned';
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
                            WHERE issue_book.approve = '$ret' AND library_users.username = '{$_SESSION['user']}'
                            ORDER BY issue_book.return DESC";
                    } elseif (isset($_POST['submit3'])) {
                        $exp = '<p> Expired </P>';
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
                            WHERE issue_book.approve = '$exp' AND library_users.username = '{$_SESSION['user']}'
                            ORDER BY issue_book.return DESC";
                    }

                    // Execute the modified SQL query
                    $res = mysqli_query($conn, $sql);

                    // Display the fetched information in a table
                    echo "<div class='scroll'>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    // Table headers
                    echo "<th>Username</th>";
                    echo "<th>User ID</th>";
                    echo "<th>Book ID</th>";
                    echo "<th>Books Name</th>";
                    echo "<th>Book Cover</th>";
                    echo "<th>Authors</th>";
                    echo "<th>Status</th>";
                    echo "<th>Book Issued Date</th>";
                    echo "<th>Book Return Date</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        // Fetch data from issue_book table
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['books_id'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['authors'] . "</td>";
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
                // User is not logged in
                echo "<h3>Please login first</h3>";
            }
            ?>


        </div>
    </div>

    <!-- ==== JS Links ==== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>