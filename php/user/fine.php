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

            <h3>Your fine is :
                <?php
                include "./fineinfo.php";
                echo "रु॰ " . $fine;
                ?>
            </h3>


            <?php
            // ========== Search user names =================
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $searchBarQuery = mysqli_query($conn, "SELECT * FROM fine WHERE username LIKE '%$search%'");

                if (mysqli_num_rows($searchBarQuery) == 0) {
                    echo "<section>";
                    echo "<div class='error_container'>";
                    echo "<img src='../../images/user_not_found.png' alt='User not found image' id='notFound'>";
                    echo "</div>";
                    echo "</section>";
                } else {
                    echo "<div>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    //Table header
                    echo "<th>";
                    echo "Username";
                    echo "</th>";
                    echo "<th>";
                    echo "book id";
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
                    echo "Status";
                    echo "</th>";

                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                        echo "<tr>";
                        //fetch data from fine table
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['bid'] . "</td>";
                        echo "<td>" . $row['returned'] . "</td>";
                        echo "<td>" . $row['days'] . "</td>";
                        echo "<td>" . $row['fine'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
            } else {
                // Fetch data for the logged-in user
                if (isset($_SESSION['user'])) {
                    $loggedInUser = $_SESSION['user'];
                    $result = mysqli_query($conn, "SELECT * FROM `fine` WHERE username = '$loggedInUser'");
                    if ($result) {
                        echo "<div>";
                        echo "<table class='table table-bordered table-hover'>";
                        echo "<tr>";
                        //Table header
                        echo "<th>";
                        echo "Username";
                        echo "</th>";
                        echo "<th>";
                        echo "book id";
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
                        echo "Status";
                        echo "</th>";

                        echo "</tr>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            //fetch data from fine table
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['bid'] . "</td>";
                            echo "<td>" . $row['returned'] . "</td>";
                            echo "<td>" . $row['days'] . "</td>";
                            echo "<td>" . $row['fine'] . "</td>";
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
            }
            ?>
        </div>
    </div>

</body>

</html>