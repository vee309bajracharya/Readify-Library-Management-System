<?php
include "./userNavbar.php"; //userNavbar
require_once "../config.php"; //database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- ===== Bootstrap link ======== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- ======== Inline CSS ============ -->
    <style>
        body {
            transition: background-color .5s;
        }

        .sidenav {
            margin-top: 50px;
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #5955E7;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 1.4rem;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

    <section id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a>
        <a href="#">Change Password</a>
        <a href="#">My Profile</a>
        <a href="#">View Archieve Books</a>
        <a href="#">Submit Book Request</a>
        <a href="#">About Readify</a>
    </section>

    <div id="main">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; open</span>
    </div>

    <!--  ===== Seach bar  ===== -->
    <div class="searchBar__wrapper">
        <div>
            <form action="" class="navbar-form" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control" type="text" name="search" placeholder="Search books" style="width: 20%" ; required>
                    <button style="background-color:var(--primary-color); color:white;" type="submit" name="submit" class="btn btn-default">Search</button>
                </div>
            </form>
        </div>

    </div>

    <div>
        <h2 class="heading-small">Books List</h2>
    </div>

    <?php
    // ==========  for searchbar =================
    if (isset($_POST['submit'])) {
        $searchBarQuery = mysqli_query($conn, "SELECT * FROM  library_books WHERE books_name like '%$_POST[search]%'");
        if (mysqli_num_rows($searchBarQuery) == 0) {
            echo "<section>Book not Found</section>";
        } else {
            echo "<section>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr style='background-color: #999;'>";
            //Table header
            echo "<th>";
            echo "Books ID";
            echo "</th>";
            echo "<th>";
            echo "Books Name";
            echo "</th>";
            echo "<th>";
            echo "Edition";
            echo "</th>";
            echo "<th>";
            echo "Authors";
            echo "</th>";
            echo "<th>";
            echo "Status";
            echo "</th>";
            echo "<th>";
            echo "Quantity";
            echo "</th>";
            echo "<th>";
            echo "Department";
            echo "</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                echo "<tr>";
                //fetch data from library_books table
                echo "<td>" . $row['books_id'], "</td>";
                echo "<td>" . $row['books_name'], "</td>";
                echo "<td>" . $row['edition'], "</td>";
                echo "<td>" . $row['authors'], "</td>";
                echo "<td>" . $row['status'], "</td>";
                echo "<td>" . $row['quantity'], "</td>";
                echo "<td>" . $row['department'], "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</section>";
        }
    } else {
        $result = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_name` ASC;");
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr style='background-color : white;'>";
        //Table header
        echo "<th>";
        echo "Books ID";
        echo "</th>";
        echo "<th>";
        echo "Books Name";
        echo "</th>";
        echo "<th>";
        echo "Edition";
        echo "</th>";
        echo "<th>";
        echo "Authors";
        echo "</th>";
        echo "<th>";
        echo "Status";
        echo "</th>";
        echo "<th>";
        echo "Quantity";
        echo "</th>";
        echo "<th>";
        echo "Department";
        echo "</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            //fetch data from library_books table
            echo "<td>" . $row['books_id'], "</td>";
            echo "<td>" . $row['books_name'], "</td>";
            echo "<td>" . $row['edition'], "</td>";
            echo "<td>" . $row['authors'], "</td>";
            echo "<td>" . $row['status'], "</td>";
            echo "<td>" . $row['quantity'], "</td>";
            echo "<td>" . $row['department'], "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    ?>




    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "350px";
            document.getElementById("main").style.marginLeft = "300px";
            //document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.body.style.backgroundColor = "white";
        }
    </script>






</body>
</html>