<?php
include "./userNavbar.php";
require_once "../config.php";

$searchBarQuery = null; // Set a default value for $searchBarQuery

if (isset($_SESSION['user'])) {
    $searchBarQuery = mysqli_query($conn, "SELECT 
        issue_book.books_id, 
        library_books.books_name, 
        library_books.book_cover, 
        issue_book.approve,
        issue_book.issue,
        issue_book.requested,
        issue_book.
        `return` FROM issue_book INNER JOIN library_books ON issue_book.books_id = library_books.books_id WHERE issue_book.username='$_SESSION[user]'");
} else {
    echo "No user specified.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books</title>

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

            <h3>View Requested Books Details</h3>

            <?php
            if ($searchBarQuery) {
                if (mysqli_num_rows($searchBarQuery) == 0) {
                    echo "<section>";
                    echo "<div class='error_container'>";
                    echo "<img src='../../images/no_pending_req.png' alt='No pending request image' id='notFound'>";
                    echo "</div>";
                    echo "</section>";
                } else {
                    echo "<div>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    //Table header
            
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
                    echo "Requested Date";
                    echo "</th>";
                    echo "<th>";
                    echo "Approve/Book Status";
                    echo "</th>";
                    echo "<th>";
                    echo "Book Issued Date";
                    echo "</th>";
                    echo "<th>";
                    echo "Book Return Date";
                    echo "</th>";



                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                        echo "<tr>";
                        //fetch data from issue_book table
                        echo "<td>" . $row['books_id'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['requested'] . "</td>";
                        echo "<td>" . $row['approve'] . "</td>";
                        echo "<td>" . $row['issue'] . "</td>";
                        echo "<td>" . $row['return'] . "</td>";

                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } else {
                echo "<br><br><br>";
                echo "<h2> Please log in first <h2>";
            }
            ?>

            <div class="request-msg">
                <p>Note: Any requested book will be dispatched promptly and will reach to you within 48 hours.</p>
            </div>
        </div>
    </div>

    <!-- jquery, popper, bootstrapJS -->
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