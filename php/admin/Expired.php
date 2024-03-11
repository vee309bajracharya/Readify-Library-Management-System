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
    <title>Issued Books</title>
    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
 <!-- Sidebar -->
 <div id="mySidenav" class="sidenav">
        <div class="logo-container">
            <a href="./list_book_for_user.php">
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
        <a href="./Expired.php"><i class='bx bxs-user-account' ></i> Expired Date</a>
        <a href="./admin-LogOut.php"><i class="bx bx-log-out"></i> Log out</a>

        </div>

    </div>

    <div id="main">
        <!-- JavaScript for sidebar -->
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "300px";
                document.getElementById("main").style.marginLeft = "300px";
                document.body.style.backgroundColor = "white";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.body.style.backgroundColor = "white";
            }
        </script>
            <div class="container">
                <button name="submit2" class="btn btn-default">Returned</button>
                <button name="submit3" class="btn btn-default">Expired</button>





            <?php
            if(isset($_SESSION['admin'])){
                ?>
            <div class="searchBar__wrapper">
            <h2> Request Book </h2>
            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="username" placeholder="Username" style="width:100%" required>
                    <input type="text" name="book_id" class="form-control" placeholder="books_id" style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Search Book</button>
                </div>
            </form>
        </div>
                <?php 

if(isset($_POST['submit'])){
    $var1 = '<p> Returned </p>';
    $sql = "UPDATE issue_book SET approve='$var1' WHERE username='$_POST[username]' AND books_id='$_POST[book_id]'";
    mysqli_query($conn, $sql);
}

            }
            ?>
            <h2>Books Past Due Date</h2>



            <?php
            $c=0;
    if (isset($_SESSION["admin"])) {
     
        $sql = "SELECT library_users.username, user_id, issue_book.books_id, library_books.books_name, library_books.authors, 
        library_books.edition,issue_book.approve,  issue_book.issue,issue_book.return                
        FROM library_users INNER JOIN issue_book ON library_users.username = issue_book.username 
        INNER JOIN library_books ON issue_book.books_id = library_books.books_id WHERE issue_book.approve != ''  AND  issue_book.approve != 'Yes'ORDER BY 
        issue_book.return DESC";

        if(isset($_POST['submit2'])){
            

        }else if($_POST['submit3']){

        }








   $res = mysqli_query($conn, $sql);
   echo "<div>";

   echo "<table class='table table-bordered table-hover' style='width:100%;'> ";
  
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
   echo "Authors";
   echo "</th>";
   echo "<th>";
   echo "Edition";
   echo "</th>";
   echo "<th>";
   echo "Status";
   echo "</th>";
   echo "<th>";
   echo "Issued Date";
   echo "</th>";
   echo "<th>";
   echo "Return Date";
   echo "</th>";
        
   echo "</tr>";
   echo "</table>";

   echo"<div class='scroll'>";
   echo "<table class='table table-bordered table-hover'>";
   while ($row = mysqli_fetch_assoc($res)) {
   
    
       echo "<tr>";
       //fetch data from issue_book table
       echo "<td>" . $row['username'] . "</td>";
       echo "<td>" . $row["user_id"] . "</td>";
       echo "<td>" . $row['books_id'] . "</td>";
       echo "<td>" . $row['books_name'] . "</td>";
       echo "<td>" . $row['authors'] . "</td>";
       echo "<td>" . $row['edition'] . "</td>";
       echo "<td>" . $row['approve'] . "</td>";
       echo "<td>" . $row['issue'] . "</td>";
       echo "<td>" . $row['return'] . "</td>";

       echo "</tr>";
   }
  
   
   echo"</div>";

    }else{
      ?>  <h3> Please login first </h3>
        <?php
    }
            ?>
            </div>
        <body>
            </html>
