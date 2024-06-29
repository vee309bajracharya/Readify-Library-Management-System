<?php
include "./userNavbar.php";
require_once "../config.php";


// Count Expired and Lost Books
$query = "SELECT count(*) as count FROM issue_book WHERE username = '$_SESSION[user]' AND (approve = 'Expired' OR approve = 'Book Lost')";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$expiredAndLostBooksCount = $row['count'];

// Count Unpaid Fines for Expired and Lost Books
$query1 = "SELECT count(*) as count FROM fine WHERE username = '$_SESSION[user]' AND (book_status = 'Expired' OR book_status = 'Book Lost') AND status = 'unpaid'";
$result1 = mysqli_query($conn, $query1);
$row1 = mysqli_fetch_assoc($result1);
$unpaidFinesCount = $row1['count'];

// Summing the Results
$finalFineCount = $expiredAndLostBooksCount + $unpaidFinesCount;
echo $finalFineCount;

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




            <div class="count-amount-container ">
                <div class="count-info-list d-flex gap-4">
                    <h3 class="fs-3">Expired Books: <?php echo $finalFineCount; ?></h3> <br>
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
                        <button type="submit" name="submit4" class="btn btn-default">Approved</button>
                                <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                                <button type="submit" name="submit2" class="btn btn-default">Book Lost</button>
                    </form>
                ';

                    if (isset($_POST['submit1'])) {
                        // Display all information for the logged-in user
            
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
                                WHERE issue_book.approve LIKE '%Book Lost%' AND library_users.username = '{$_SESSION['user']}'
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
                                WHERE issue_book.approve LIKE '%Expired%' AND library_users.username = '{$_SESSION['user']}'
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
                                WHERE issue_book.approve LIKE '%Approved%' AND library_users.username = '{$_SESSION['user']}'
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