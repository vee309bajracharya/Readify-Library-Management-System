<?php
include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery

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

            <?php
            $c = 0;
            if (isset($_SESSION["admin"])) {
                $sql = "SELECT * FROM returned_book";
                $res = mysqli_query($conn, $sql);
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




                while ($row = mysqli_fetch_assoc($res)) {


                    echo "<tr>";
                    //fetch data from issue_book table
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


                echo "</div>";
            } else {
                ?>
                <h3> Please login first </h3>
                <?php
            }
            ?>
        </div>
    </div>

    <body>

</html>