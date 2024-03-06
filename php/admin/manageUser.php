
<?php 
    include "./adminNavbar.php"; //navbar along with sidenav
    require_once "../config.php"; //database connection file

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

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
    <div class="logo-container">
            <a href="./adminDashboard.php">
                <img src="../../svg/logo-1.svg" alt="Readify Logo">
            </a>
        </div>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        
        <div class="links">
        <a href="./adminDashboard.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <a href="./Request.php"><i class='bx bxs-dashboard'></i> Manage Request</a>
        <a href="./Issued.php"><i class='bx bxs-book-add'></i> Add Books</a>
        <a href="./Managebooks.php"><i class='bx bxs-folder-open'></i> Manage Books</a>
        <a href="#"><i class='bx bx-money-withdraw'></i> Fine Collected</a>
        <a href="./manageUser.php"><i class='bx bxs-user-account' ></i> Manage Users</a>
        <a href="./admin-LogOut.php"><i class="bx bx-log-out"></i> Log out</a>

        </div>
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
    <h1> List of Users </h1>
    <div class="searchBar__wrapper">
            <form action="" class="navbar-form" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control" type="text" name="search" placeholder="Search User" style="width:100%" ; required>
                    <button type="submit" name="submit" class="btn-search">Search</button>
                </div>
            </form>
    </div>

      
    <?php
// ========== search book names =================
if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $searchBarQuery = mysqli_query($conn, "SELECT fullname, username, email, phone_number, address, library_card_number FROM library_users WHERE fullname LIKE '%$search%'");

    if (mysqli_num_rows($searchBarQuery) == 0) {
        echo "<section> User not found </section>";
    } else {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        //Table header
        echo "<th>"; echo "Full Name"; echo "</th>";
        echo "<th>"; echo "Username"; echo "</th>";
        echo "<th>"; echo "Email"; echo "</th>";
        echo "<th>"; echo "Phone Number"; echo "</th>";
        echo "<th>"; echo "Address"; echo "</th>";
        echo "<th>"; echo "Library Card Number"; echo "</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($searchBarQuery)) {
            echo "<tr>";
            //fetch data from library_books table
            echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['library_card_number'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        }
        }else {
            $result = mysqli_query($conn, "SELECT fullname, username, email, phone_number, address, library_card_number FROM `library_users`;");
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            //Table header
            echo "<th>"; echo "Full Name"; echo "</th>";
        echo "<th>"; echo "Username"; echo "</th>";
        echo "<th>"; echo "Email"; echo "</th>";
        echo "<th>"; echo "Phone Number"; echo "</th>";
        echo "<th>"; echo "Address"; echo "</th>";
        echo "<th>"; echo "Library Card Number  "; echo "</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                //fetch data from library_books table
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['library_card_number'] . "</td>";
             
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