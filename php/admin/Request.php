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
    <title>Request Books list</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

</head>

<body>

    <!-- include Sidebar -->
    <?php
    include "./adminSidebar.php";
    ?>

    <div class="list_container">
        <div id="main">




            <h2> Select Books for Approval </h2>

            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="username" placeholder="Username" style="width:100%" required>
                    <input type="text" name="book_id" class="form-control-search" placeholder="books_id" style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Approve</button>
                </div>
            </form>

        </div>


        <?php
        if (isset($_SESSION['admin'])) {
            $sql = "SELECT 
                library_users.username, 
                user_id, 
                issue_book.books_id, 
                library_books.books_name,
                library_books.book_cover,
                library_books.authors, 
                library_books.edition, 
                library_books.status 
            FROM 
                library_users 
            INNER JOIN 
                issue_book ON library_users.username = issue_book.username 
            INNER JOIN 
                library_books ON issue_book.books_id = library_books.books_id 
            WHERE 
                issue_book.approve = ''";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) == 0) {
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
                echo "Student Username";
                echo "</th>";
                echo "<th>";
                echo "User ID";
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
                echo "Edition";
                echo "</th>";
                echo "<th>";
                echo "Status";
                echo "</th>";

                echo "</tr>";
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>";
                    //fetch data from issue_book table
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row["user_id"] . "</td>";
                    echo "<td>" . $row['books_id'] . "</td>";
                    echo "<td>" . $row['books_name'] . "</td>";
                    echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                    echo "<td>" . $row['authors'] . "</td>";
                    echo "<td>" . $row['edition'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";

                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            }
        } else {
        ?>
            <br> <br> <br>
            <h3> You need to login to see the request</h3>

        <?php
        }
        if (isset($_POST['submit'])) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['books_id'] = $_POST['book_id'];
        ?>
            <script>
                window.location = "Approve.php";
            </script>
        <?php
        }
        ?>
    </div>
    </div>
    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
    include('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>