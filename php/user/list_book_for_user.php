<?php 
    include "./userNavbar.php"; //navbar along with sidenav
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

   
    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

   

</head>
<body>
    
    <!-- ====== Sidebar ======== -->
    <div id="mySidenav" class="sidenav">    
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        
        <a href="./list_book_for_user.php"><i class='bx bxs-dashboard' ></i> Dashboard</a>
        <a href="#"><i class="ri-lock-password-fill"></i> Change Password</a>
        <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
        <a href="#"><i class='bx bxs-book'></i> View Issued Books</a>
        <a href="#"><i class='bx bxs-book'></i> View Archieve Books</a>
        <a href="#"><i class='bx bxs-book'></i> Submit Book Request</a>
        <a href="#"><i class='bx bxs-help-circle' ></i> About Readify</a>
        <a href="./logOut.php"><i class="bx bx-log-out"></i> Log out</a>
      </div>
      
      <div id="main">
      
      <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
        document.getElementById("main").style.marginLeft = "300px";
        document.body.style.backgroundColor = "white";
      }
      
      function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft= "0";
        document.body.style.backgroundColor = "white";
      }
      </script>

      <!-- ==== Sidebar ends here ===== -->
         




    <!--  ===== Seachbar for books ===== -->
    <div class="searchBar__wrapper">
            <form action="" class="navbar-form" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control" type="text" name="search" placeholder="Type Book Name" style="width:100%" ; required>
                    <button type="submit" name="submit" class="btn-search">Search</button>
                </div>
            </form>
    </div>


    <?php
// ========== search book names =================
if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");

    if (mysqli_num_rows($searchBarQuery) == 0) {
        echo "<section>Book not Found</section>";
    } else {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
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
        }else {
            $result = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_name` ASC;");
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
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


    
   <!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </div>
</body>
</html>