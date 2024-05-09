<?php
include "./userNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Details</title>

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
            <h1>Fine Details </h1>


            <h4> <?php

            include "./finedbooks.php";
            include "./fineinfo.php";


            echo "Expired's count :{$totalExpiredCount} <br>";
            echo "Expired's Fine: NRS{$totalExpiredFine} <br>";


            echo "  Book Lost count's Fine: NRS {$totalBookLostCount}<br>";
            echo "  Book Lost's Fine: NRS {$totalLostFine}<br>";

            ?>
            </h4>



            <?php
            // ========== Search user names =================
            // Fetch data for the logged-in user
            if (isset($_SESSION['user'])) {
                $loggedInUser = $_SESSION['user'];
                $result = mysqli_query($conn, "SELECT fine.*, library_books.books_name, library_books.book_cover, book_status
                    FROM `fine` 
                    INNER JOIN library_books ON fine.bid = library_books.books_id 
                    WHERE fine.username = '$loggedInUser' AND fine > 0");

                if ($result) {
                    echo "<div>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    //Table header
                    echo "<th>";
                    echo "Username";
                    echo "</th>";
                    echo "<th>";
                    echo "Book ID";
                    echo "</th>";
                    echo "<th>";
                    echo "Books Name";
                    echo "</th>";
                    echo "<th>";
                    echo "Book Cover";
                    echo "</th>";
                    echo "<th>";
                    echo "Returned";
                    echo "</th>";
                    echo "<th>";
                    echo "Days";
                    echo "</th>";
                    echo "<th>";
                    echo "Fine";
                    echo "</th>";
                    echo "<th>";
                    echo "Book Status";
                    echo "</th>";
                    echo "<th>";
                    echo "Status";
                    echo "</th>";

                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        //fetch data from fine table
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['bid'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['returned'] . "</td>";
                        echo "<td>" . $row['days'] . "</td>";
                        echo "<td>" . $row['fine'] . "</td>";
                        echo "<td>" . $row['book_status'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Session variable 'user' not set.";
            }
            ?>
        </div>
    </div>

</body>

</html>