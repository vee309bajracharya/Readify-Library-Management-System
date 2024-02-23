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

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">

   
    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

      <style>
        
          .book{
              width: 400px;
              margin: 0 auto;
              
          }
          .form-control{
              margin: 0 auto;
              width: 35rem;
              height: 4rem;
          }

    .add_button{
        display: block;
        margin: 0 auto;
        text-align: center;
        height: 4rem;
        width:35rem ;
        color: white;
        background-color: #5955e7;
        border-radius: 0.5rem;
    }
          .add_button{
              display: block;
              margin: 0 auto;
              text-align: center;
              height: 4rem;
              width:35rem ;
              color: white;
              background-color: #5955e7;
              border-radius: 0.5rem;
          }

        
      </style>
   

</head>
<body>
    
    <!-- ====== Sidebar ======== -->
    <div id="mySidenav" class="sidenav">    
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        
        <a href="./adminDashboard.php"><i class='bx bxs-dashboard' ></i> Dashboard</a>
        <a href="./Issued.php"><i class='bx bxs-book-add'></i> Issued Books</a>
        <a href="./manageUser.php"><i class='bx bxs-folder-open'></i> Manage Books</a>
        <a href="#"><i class='bx bx-money-withdraw'></i> Fine Collected</a>
        <a href="./manageUser.php"><i class='bx bxs-user-account' ></i> Manage Users</a>
        <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
        <a href="./admin-LogOut.php"><i class="bx bx-log-out"></i> Log out</a>


      </div>
      
      <div class="add_from" id="main">
      <h2 style="text-align:center"><i class='bx bxs-book-add'></i> Add Books</h2>
        
      <form class="book" action="./Issued.php" method="POST">
      <br>

       
        <input type="text" name="name" class="form-control" placeholder="Book Name" required=""><br>
        <input type="text" name="authors" class="form-control" placeholder="Authors" required=""><br>
        <input type="text" name="edition" class="form-control" placeholder="Edition" required=""><br>
        <input type="text" name="status" class="form-control" placeholder="Status" required=""><br>
        <input type="text" name="quantity" class="form-control" placeholder="Quantity" required=""><br>
        <input type="text" name="department" class="form-control" placeholder="Department" required=""><br>
        <input type="text" name="books_name" id="books_name" class="form-control" placeholder="Book Name" required=""><br>
        <input type="text" name="authors" id="authors" class="form-control" placeholder="Authors" required=""><br>
        <input type="text" name="edition" id="edition" class="form-control" placeholder="Edition" required=""><br>
        <input type="text" name="status"  id="status" class="form-control" placeholder="Status" required=""><br>
        <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required=""><br>
        <input type="text" name="department" id="department" class="form-control" placeholder="Department" required=""><br>
       
        <button class="add_button" type="submit">Submit</button>
      </div>

    </form>
      </div>

      <?php 
       if(isset($_POST['submit'])){
        if(isset($_SESSION['admin'])){
            mysqli_query($db,"INSERT INTO library_books VALUES ('$_POST[name]', '$_POST[authors]', '$_POST[edition]', '$_POST[status]', '$_POST[quantity]', '$_POST[department]',);");
            ?>

            <script type="text/javascript"> alert("Books Added Sucessfully!"); </script>
            <?php

        }else{
            ?>
            <script type="text/javascript"> alert("Please Login First"); </script>
            <?php
        }
       }
      ?>
        <button class="add_button" type="submit" value="submit">Submit</button>
        </form>

    


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
         


      </div>

</body>
</html>