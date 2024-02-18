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
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- ===== Bootstrap link ======== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />


</head>

<body>
    


    <!--  ===== Seach bar  ===== -->
    <section class="searchBar__wrapper">
        <div>
            <form action="" class="navbar-form" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control" type="text" name="search" placeholder="Search books" style="width: 20%" ; required>
                    <button style="background-color:var(--primary-color); color:white;" type="submit" name="submit" class="btn btn-default">Search</button>
                </div>


            </form>
        </div>

    </section>





    <section>
        <h2 class="heading-small">Books List for Users</h2>
    </section>

    <?php

    // for searchbar
    if (isset($_POST['submit'])) {

        $searchBarQuery = mysqli_query($conn, "SELECT * FROM  library_books WHERE books_name like '%$_POST[search]%'");

        if(mysqli_num_rows($searchBarQuery)==0){
            echo "<section>Book not Found</section>";
        }
        else{
            echo "<section>";
            echo "<table class='table table-bordered table-hover'>";

            echo "<tr style='background-color: #999;'>";

            //Table header
            echo "<th>"; echo "Books ID"; echo "</th>"; 
            echo "<th>"; echo "Books Name"; echo "</th>"; 
            echo "<th>"; echo "Edition"; echo "</th>";
            echo "<th>"; echo "Authors"; echo "</th>";
            echo "<th>"; echo "Status"; echo "</th>";
            echo "<th>"; echo "Quantity"; echo "</th>";
            echo "<th>"; echo "Department"; echo "</th>";

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
    }

    // ========= if button isn't pressed ============
    else{
        
    $result = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_name` ASC;");

    echo "<section>";
    echo "<table class='table table-bordered table-hover'>";

    echo "<tr style='background-color : white;'>";

    //Table header
    echo "<th>"; echo "Books ID"; echo "</th>"; 
    echo "<th>"; echo "Books Name"; echo "</th>"; 
    echo "<th>"; echo "Edition"; echo "</th>";
    echo "<th>"; echo "Authors"; echo "</th>";
    echo "<th>"; echo "Status"; echo "</th>";
    echo "<th>"; echo "Quantity"; echo "</th>";
    echo "<th>"; echo "Department"; echo "</th>";

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
    echo "</section>";
    }


    ?>

</body>

</html>