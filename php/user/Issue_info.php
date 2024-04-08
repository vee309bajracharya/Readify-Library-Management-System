<?php
include "./userNavbar.php";
require_once "../config.php";

$searchBarQuery = null; // Set a default value for $searchBarQuery

if (isset ($_SESSION['user'])) {
    $searchBarQuery = mysqli_query($conn, "SELECT books_id, approve, issue, `return` FROM issue_book WHERE username='$_SESSION[user]'");
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
                    echo "Approve Status";
                    echo "</th>";
                    // echo "<th>";echo "Request Date";echo "</th>";
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
                        echo "<td>" . $row['approve'] . "</td>";
                        // echo "<td>" . $row['request'] . "</td>";
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
        </div>
    </div>


</body>

</html>