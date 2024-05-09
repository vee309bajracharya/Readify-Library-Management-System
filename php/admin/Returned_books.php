<?php
include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery

// Check if form is submitted with a username search
if (isset($_POST['search_username'])) {
    $search_username = $_POST['search_username'];
    // Modify SQL query to filter results by entered username
    $sql = "SELECT * FROM returned_book WHERE username LIKE '%$search_username%'";
    $searchBarQuery = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$searchBarQuery) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    // If no search is performed, fetch all records
    $sql = "SELECT * FROM returned_book";
    $searchBarQuery = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$searchBarQuery) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books Info</title>
    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <style>
        .requestBar__wrapper {
            margin-bottom: 10px;
        }

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
            <h3>Returned Books List</h3>
            <!-- Add a search bar -->
            <div class="requestBar__wrapper">
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by username" name="search_username">
                        <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                    </div>
                </form>
            </div>

            <?php
            $c = 0;
            if (isset($_SESSION["admin"])) {
                echo "<div>";
                echo "<table class='table table-bordered table-hover' style='width:100%;'> ";

                echo "<tr>";
                //Table header   
                echo "<th>";
                echo "User ID";
                echo "</th>";

                echo "<th>";
                echo "Student Username";
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
                echo "Authors";
                echo "</th>";

                echo "<th>";
                echo "Book Issued Date";
                echo "</th>";

                echo "<th>";
                echo "Returned Date";
                echo "</th>";

                echo "<th>";
                echo "Book Status";
                echo "</th>";

                echo "</tr>";

                // Fetch all records or filtered records based on search
                if (mysqli_num_rows($searchBarQuery) > 0) {
                    while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                        // Fetch data from returned_book table
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row['books_id'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['authors'] . "</td>";
                        echo "<td>" . $row['issue'] . "</td>";
                        echo "<td>" . $row['returned_date'] . "</td>";
                        echo "<td>" . $row['approve'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no records found
                    echo "<tr><td colspan='9'>No records found.</td></tr>";
                }

                echo "</table>";
                echo "</div>";
            } else {
                ?>
                <h3>Please login first</h3>
                <?php
            }
            ?>
        </div>
    </div>
</body>

</html>