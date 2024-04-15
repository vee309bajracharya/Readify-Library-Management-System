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
        <h1> List of Users </h1>

            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="search searchBar_field">
                    <input class="form-control-search" type="text" name="search" placeholder="Search User" style="width:100%" ; required>
                    <button type="submit" name="submit" class="btn-search">Search</button>
                </div>
            </form>
    </div>

      
    <?php
// ========== search book names =================
if (isset($_POST['submit'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $searchBarQuery = mysqli_query($conn, "SELECT fullname, username, email, phone_number, address, library_card_number, pic FROM library_users WHERE fullname LIKE '%$search%'");

    if (mysqli_num_rows($searchBarQuery) == 0) {
        echo "<section>";
        echo "<div class='error_container'>";
        echo "<img src='../../images/user_not_found.png' alt='User not found image' id='notFound'>";
        echo "</div>";
        echo "</section>";  

    } else {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        //Table header
        echo "<th>"; echo "Full Name"; echo "</th>";
        echo "<th>"; echo "Email"; echo "</th>";
        echo "<th>"; echo "Phone Number"; echo "</th>";
        echo "<th>"; echo "Address"; echo "</th>";
        echo "<th>"; echo "Library Card Number"; echo "</th>";
        echo "<th>"; echo "Profile"; echo "</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($searchBarQuery)) {
            echo "<tr>";
            //fetch data from library_books table
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['library_card_number'] . "</td>";
                echo "<td style='text-align:center;'><img src='../user/images/" . $row['pic'] . "' alt='Profile Picture' width='100' height='100' style='object-fit: cover; border-radius: 5px;'></td>";
                echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
        }
        }else {
            $result = mysqli_query($conn, "SELECT fullname, username, email, phone_number, address, library_card_number, pic FROM `library_users`;");
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
            //Table header
            echo "<th>"; echo "Full Name"; echo "</th>";
            echo "<th>"; echo "Email"; echo "</th>";
            echo "<th>"; echo "Phone Number"; echo "</th>";
            echo "<th>"; echo "Address"; echo "</th>";
            echo "<th>"; echo "Library Card Number  "; echo "</th>";
            echo "<th>"; echo "Profile Image"; echo "</th>";

            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                //fetch data from library_books table
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['library_card_number'] . "</td>";
                echo "<td style='text-align:center;'><img src='../user/images/" . $row['pic'] . "' alt='Profile Picture' width='100' height='100' style='object-fit: cover; border-radius: 5px;'></td>";

             
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        }
?>


      </div>

    
   <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </div>
</body>
</html>