<?php
include "./userNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_req'])) {
//     $books_id = $_POST["books_id"];
//     $books_name = $_POST["books_name"];
//     $authors = $_POST['authors'];
//     $edition = $_POST['edition'];
//     $status = $_POST['status'];
//     $quantity = $_POST['quantity'];
//     $department = $_POST['department'];

//     // Check if the book exists and quantity is less than 40
//     $checkbook_query = "SELECT * FROM library_books WHERE books_id = '$books_id' AND quantity < 40";
//     $checkbook_result = mysqli_query($conn, $checkbook_query);

//     if (mysqli_num_rows($checkbook_result) > 0) {
//         // Check if the book has already been requested by the user
//         $check_request_query = "SELECT * FROM pending_req WHERE books_id = '$books_id' AND status = 'Pending'";
//         $check_request_result = mysqli_query($conn, $check_request_query);

//         if (mysqli_num_rows($check_request_result) > 0) {
//             echo "Book request is already pending!";
//         } else {
//             // Book exists and quantity is less than 40, insert into pending_req table
//             $insert_query = "INSERT INTO pending_req (books_id, books_name, authors, edition, status, quantity, department) VALUES ('$books_id', '$books_name', '$authors', '$edition', '$status', '$quantity', '$department')";
//             if (mysqli_query($conn, $insert_query)) {
//                 // Redirect to prevent resubmission
//                 header("Location: ".$_SERVER['PHP_SELF']);
//                 exit();
//             } else {
//                 echo "Error: " . mysqli_error($conn);
//             }
//         }
//     } else {
//         echo "Book doesn't exist or quantity is not less than 40";
//     }
// }
// ?>

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
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .requestBar__wrapper{
            margin-bottom: 10px;
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


        <!-- Profile preview -->
        <div style="margin-top:1.4rem; margin-bottom: 2rem;" class="d-flex flex-column align-items-center text-center">
            <?php
            echo '<div class="custom-links">';
            echo '<img class="img-circle profile_img" width="80" height="80" src="./images/' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover; margin-top:1.3rem;">';
            echo "Welcome," . $_SESSION['user'];
            echo '</div>';
            ?>
        </div>

        <div class="links">
            <a href="./list_book_for_user.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
            <a href="./change_password.php"><i class="ri-lock-password-fill"></i> Change Password</a>
            <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
            <a href="#"><i class='bx bxs-book'></i> View Issued Books</a>
            <a href="#"><i class='bx bxs-book'></i> View Archieve Books</a>
            <a href="#"><i class='bx bxs-book'></i> Submit Book Request</a>
            <a href="./about_readify.php"><i class='bx bxs-help-circle'></i> About Readify</a>
            <a href="./logOut.php"><i class="bx bx-log-out"></i> Log out</a>
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

        <!-- Search bar for books -->
        <div class="searchBar__wrapper">
            <h2> Request Book </h2>

            <div class="requestBar__wrapper">
            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="books_id" placeholder="Enter book id" style="width:100%" required>
                    <button type="submit" name="request" class="btn-search">Request book</button>
                </div>
            </form>
        </div>

            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="search" placeholder="Type Book Name" style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Search Book</button>
                </div>
            </form>
        </div>

        

        <!-- PHP code to display books and handle book request submission -->
        <?php
        // Fetch book data from the database
        if (isset($_POST['submit'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
        } else {
            $searchBarQuery = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_name` ASC;");
        }
        

        if (mysqli_num_rows($searchBarQuery) == 0) {
            echo "<section>Book not Found</section>";
        } else {
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            echo "<tr>";
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
            // echo "<th>";
            // echo "Action";
            // echo "</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                // Check if the book has already been requested by the user
                $check_request_query = "SELECT * FROM pending_req WHERE books_id = '{$row['books_id']}' AND status = 'Pending'";
                $check_request_result = mysqli_query($conn, $check_request_query);

                // If the book hasn't been requested, display it
                if (mysqli_num_rows($check_request_result) == 0) {
                    echo "<tr>";
                    //fetch data from library_books table
                    echo "<td>" . $row['books_id'] . "</td>";
                    echo "<td>" . $row['books_name'] . "</td>";
                    echo "<td>" . $row['edition'] . "</td>";
                    echo "<td>" . $row['authors'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "<td>" . $row['department'] . "</td>";
                    echo "<td>";
                    // Book request form for each book
                    echo "<form action='' method='POST'>";
                    echo "<input type='hidden' name='books_id' value='" . $row['books_id'] . "'>";
                    echo "<input type='hidden' name='books_name' value='" . $row['books_name'] . "'>";
                    echo "<input type='hidden' name='authors' value='" . $row['authors'] . "'>";
                    echo "<input type='hidden' name='edition' value='" . $row['edition'] . "'>";
                    echo "<input type='hidden' name='status' value='" . $row['status'] . "'>";
                    echo "<input type='hidden' name='quantity' value='" . $row['quantity'] . "'>";
                    echo "<input type='hidden' name='department' value='" . $row['department'] . "'>";
                    // echo "<button type='submit' name='submit_req' class='btn btn-success' >Request</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
            echo "</div>";
        }
        if(isset($_POST['request']))
        {
           if(isset($_SESSION['user'])) {
            
                mysqli_query($db,"INSERT INTO issued_book Values('$_SESSION[user]','$_POST[books_id]','','','');");
           }else{
            ?>
            <script type="text/javascript"> alert("Your must login first to Request a book"); </script>
            <?php 
            
            
           }
        }
        ?>

    </div>
</body>
</html>
