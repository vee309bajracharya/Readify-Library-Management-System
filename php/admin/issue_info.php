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

        .scroll{
            width: 100%;
            height: 500px;
            overflow: auto;

        }

        th,td{
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

            <?php
            $c = 0;
            if (isset($_SESSION["admin"])) {
                $sql = "SELECT 
                    library_users.username, 
                    user_id, 
                    issue_book.books_id, 
                    library_books.books_name,
                    library_books.book_cover, 
                    library_books.authors, 
                    issue_book.issue,
                    issue_book.return                
                    FROM 
                    library_users 
                    INNER JOIN 
                    issue_book ON library_users.username = issue_book.username 
                    INNER JOIN 
                    library_books ON issue_book.books_id = library_books.books_id 
                    WHERE 
                    issue_book.approve = 'Approved' 
                    ORDER BY 
                    issue_book.return ASC;
                    ";
                $res = mysqli_query($conn, $sql);
                echo "<div>";

                echo "<table class='table table-bordered table-hover' style='width:100%;'> ";

                echo "<tr>";
                //Table header   

                echo "<th>";echo "Student Username";echo "</th>";
                echo "<th>";echo "User ID";echo "</th>";
                echo "<th>";echo "Book ID";echo "</th>";
                echo "<th>";echo "Books Name";echo "</th>";
                echo "<th>";echo "Book Cover";echo "</th>";
                echo "<th>";echo "Authors";echo "</th>";
                echo "<th>";echo "Book Issued Date";echo "</th>";
                echo "<th>";echo "Book Return Date";echo "</th>";

                echo "</tr>";
                echo "</table>";

                echo "<div class='scroll'>";
                echo "<table class='table table-bordered table-hover'>";
                while ($row = mysqli_fetch_assoc($res)) {
                    $d = date("Y-m-d");

                    if ($d > $row['return']) {
                        $c = $c + 1;
                        $var = '<p> Expired </P>';
                        mysqli_query($conn, "UPDATE issue_book SET approve='$var' WHERE `return`='{$row['return']}' AND approve ='Approved' limit $c;");
                        echo $d . "</br>";
                    }

                    echo "<tr>";
                    //fetch data from issue_book table
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row['books_id'] . "</td>";
                    echo "<td>" . $row['books_name'] . "</td>";
                    echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                    echo "<td>" . $row['authors'] . "</td>";
                    echo "<td>" . $row['issue'] . "</td>";
                    echo "<td>" . $row['return'] . "</td>";

                    echo "</tr>";
                }


                echo "</div>";
            } else {
            ?> <h3> Please login first </h3>
            <?php
            }
            ?>
        </div>
    </div>

<body>
</html>
