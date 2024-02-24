<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; //database connection file

if (isset($_POST['submit'])) {
    if (isset($_SESSION['admin'])) {
        $books_name = $_POST['books_name'];
        $authors = $_POST['authors'];
        $edition = $_POST['edition'];
        $status = $_POST['status'];
        $quantity = $_POST['quantity'];
        $department = $_POST['department'];

        $stmt = $conn->prepare("INSERT INTO library_books (books_name, authors, edition, status, quantity, department) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $books_name, $authors, $edition, $status, $quantity, $department);

        if ($stmt->execute()) {
            echo "<script>alert('Successfully Books Added')</script>";
            echo "<script>window.location.href = './Issued.php';</script>";
            exit; // Stop execution after redirection
        } else {
            echo "<script>alert('Error Adding Book: " . $stmt->error . "')</script>";
        }

        $stmt->close();
    }
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

        .book {
            width: 400px;
            margin: 0 auto;

        }

        .form-control {
            margin: 0 auto;
            width: 35rem;
            height: 4rem;
        }

        .add_button {
            display: block;
            margin: 0 auto;
            text-align: center;
            height: 4rem;
            width: 35rem;
            color: white;
            background-color: #5955e7;
            border-radius: 0.5rem;
            transition: 0.3s ease-in-out ;
        }

        .add_button:hover{
            background-color: var( --hover-color1);
        }

        .add-cancel {
    display: flex;
    margin: 0 auto;
    align-items: center; 
    justify-content: center; 
    margin-top: 1.5rem;
    height: 4rem;
    width: 35rem;
    color: white;
    background-color: #5955e7;
    border-radius: 0.5rem;
    transition: 0.3s ease-in-out ;
}

.add-cancel:hover {
    color: white;   
    text-decoration: none;
    cursor: pointer; 
    background-color: var( --hover-color1);
}


    </style>


</head>

<body>

    <!-- ====== Sidebar ======== -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <a href="./adminDashboard.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <a href="./Issued.php"><i class='bx bxs-book-add'></i> Issued Books</a>
        <a href="./manageUser.php"><i class='bx bxs-folder-open'></i> Manage Books</a>
        <a href="#"><i class='bx bx-money-withdraw'></i> Fine Collected</a>
        <a href="./manageUser.php"><i class='bx bxs-user-account'></i> Manage Users</a>
        <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
        <a href="./admin-LogOut.php"><i class="bx bx-log-out"></i> Log out</a>


    </div>

    <div class="add_from" id="main">
        <h2 style="text-align:center"><i class='bx bxs-book-add'></i> Add Books</h2>

        <form class="book" action="./Issued.php" method="POST">
            <br>

            <input type="text" name="books_name" id="books_name" class="form-control" placeholder="Book Name" required=""><br>
            <input type="text" name="authors" id="authors" class="form-control" placeholder="Authors" required=""><br>
            <input type="text" name="edition" id="edition" class="form-control" placeholder="Edition" required=""><br>
            <input type="text" name="status" id="status" class="form-control" placeholder="Status" required=""><br>
            <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" required=""><br>
            <input type="text" name="department" id="department" class="form-control" placeholder="Department" required=""><br>

            <button class="add_button" type="submit" name="submit" value="submit">Submit</button>
            <a class="add-cancel" style=" margin-top: 1.5rem;" href="./adminDashboard.php">Cancel</a>

        </form>



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

        <!-- ==== Sidebar ends here ===== -->


    </div>

</body>

</html>