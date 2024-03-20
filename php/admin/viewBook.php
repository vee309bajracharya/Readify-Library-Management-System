<?php 
    include "./adminNavbar.php"; //navbar along with sidenav
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

</head>
<body>
    
<!-- include Sidebar -->
    <?php 
        include "./adminSidebar.php";
    ?>

    <div class="list_container">
    <div id="main">
      

      <!--  ===== Seachbar for books ===== -->
      <div class="searchBar__wrapper">
          <h2> View Books </h2>
              <form action="" class="navbar-form-c" method="POST" name="form-1">
                  <div class="search searchBar_field">
                      <input class="form-control-search" type="text" name="search" placeholder="Type Book Name" style="width:100%" ; required>
                      <button type="submit" name="submit" class="btn-search">Search</button>
                  </div>
              </form>
      </div>

       <!-- PHP code to display books -->
       <?php
        // Fetch book data from the database
        if (isset($_POST['submit'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
        } else {
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_id` ASC;");
        }


        if (mysqli_num_rows($searchBarQuery) == 0) {
            echo "<section>";
            echo "<div class='error_container'>";
            echo "<img src='../../images/book_not_found.png' alt='Book Not Found' id='notFound'>";
            echo "</div>";
            echo "</section>";
        } else {
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            //Table header
            echo "<th>";echo "Books ID";echo "</th>";
            echo "<th>";echo "Books Name";echo "</th>";
            echo "<th>";echo "Edition";echo "</th>";
            echo "<th>";echo "Authors";echo "</th>";
            echo "<th>";echo "Status";echo "</th>";
            echo "<th>";echo "Quantity";echo "</th>";
            echo "<th>";echo "Department";echo "</th>";

            echo "</tr>";

            while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                echo "<tr>";
                //fetch data from library_books table
                echo "<td>" . $row['books_id'] . "</td>";
                echo "<td>" . $row['books_name'] . "</td>";
                echo "<td>" . $row['edition'] . "</td>";
                echo "<td>" . $row['authors'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
        ?>

  
  

    </div>
      

    </div>
</body>
</html>