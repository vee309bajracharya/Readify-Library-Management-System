<?php
    include "./adminNavbar.php"; // Include the admin navbar
    require_once "../config.php"; // Include the database connection file

    // Fetch pending requests from the database
    $pending_req_query = "SELECT books_id, books_name, authors, edition, status, quantity, department FROM pending_req";
    $pending_req_result = mysqli_query($conn, $pending_req_query);

    // Display pending requests in a table
    if (mysqli_num_rows($pending_req_result) > 0) {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        // Table header
        echo "<th>"; echo "Books ID"; echo "</th>";
        echo "<th>"; echo "Books Name"; echo "</th>";
        echo "<th>"; echo "Edition"; echo "</th>";
        echo "<th>"; echo "Authors"; echo "</th>";
        echo "<th>"; echo "Status"; echo "</th>";
        echo "<th>"; echo "Quantity"; echo "</th>";
        echo "<th>"; echo "Department"; echo "</th>";
        echo "<th>"; echo "Action"; echo "</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($pending_req_result)) {
            echo "<tr>";
            // Fetch data from the pending_req table
            echo "<td>" . $row['books_id'] . "</td>";
            echo "<td>" . $row['books_name'] . "</td>";
            echo "<td>" . $row['edition'] . "</td>";
            echo "<td>" . $row['authors'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['department'] . "</td>";
            echo "<td>";
            // Approve and Decline buttons
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='books_id' value='" . $row['books_id'] . "'>";
            echo "<button type='submit' name='approve_req' class='btn btn-success'>Approve</button>";
            echo "<button type='submit' name='decline_req' class='btn btn-danger'>Decline</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "No pending requests found.";
    }

    // Handle approval or decline of requests
    if (isset($_POST['approve_req'])) {
        $books_id = $_POST['books_id'];

        // Update the status for the corresponding books_id
        $update_query = "UPDATE pending_req SET status = 'Approved' WHERE books_id = '$books_id'";
        mysqli_query($conn, $update_query);

        echo "Books ID: $books_id has been approved.";
    }

    if (isset($_POST['decline_req'])) {
        $books_id = $_POST['books_id'];

        // Delete the request with the corresponding books_id
        $delete_query = "DELETE FROM pending_req WHERE books_id = '$books_id'";
        mysqli_query($conn, $delete_query);

        echo "Books ID: $books_id has been declined.";
    }
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

   <style>
   .bxs-book-add{
    margin-right: 1.3rem;
   }
    .navbar-form-c{
    width: 100%;
    padding-top: 0;
    padding-bottom: 0;
    margin-right: 0px;
    border: 0;
    box-shadow: none;
  }
    .form-control-search{
        padding: 10px;
    }

    .btn-search{
    background-color: var(--primary-color);
    color: white;
    width: 40%;
    height: 10%;
    padding: 10px;
    border-radius: 3px;
    border: none;
    text-align: center;
    transition: 0.3s ease-in-out ;
  }
  .btn-search:hover{
    text-decoration: none;
    color: white;
    background-color: var( --hover-color1);
  }

  .btn-add-book:hover{
    text-decoration: none;
    color: white;
    background-color: var( --hover-color1);
  }
   </style>

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
        <a href="./Approve.php"><i class='bx bxs-dashboard'></i> Manage Request</a>
        <a href="./Issued.php"><i class='bx bxs-book-add'></i> Issued Books</a>
        <a href=""><i class='bx bxs-folder-open'></i> Manage Books</a>
        <a href="#"><i class='bx bx-money-withdraw'></i> Fine Collected</a>
        <a href="./manageUser.php"><i class='bx bxs-user-account' ></i> Manage Users</a>
        <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
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
         <!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </div>
</body>
</html>