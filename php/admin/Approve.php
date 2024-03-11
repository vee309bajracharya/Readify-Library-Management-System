<?php
include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Request</title>
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

        .form-control {
            margin: 0 auto;
            width: 35rem;
            height: 4rem;
        }

        .approve_button {
            display: block;
            margin: 0 auto;
            text-align: center;
            height: 4rem;
            width: 35rem;
            color: white;
            background-color: #5955e7;
            border-radius: 0.5rem;
            transition: 0.3s ease-in-out;
        }

        .approve_button:hover {
            background-color: var(--hover-color1);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="mySidenav" class="sidenav">
        <!-- Sidebar content -->
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
            <a href="./manageUser.php"><i class='bx bxs-user-account'></i> Manage Users</a>
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
            <h2 style="text-align: center; margin-bottom: 30px;">Approve Request</h2>
            <form class="Approve" action="" method="post">
                <input class="form-control" type="text" name="approve" placeholder="Approve or not" required><br>
                <input class="form-control" type="date" name="issue" placeholder="Issue Date yyyy-mm-dd" required><br>
                <input class="form-control" type="date" name="return" placeholder="Return Date yyyy-mm-dd" required><br>
                <button class="btn btn-default approve_button" type="submit" name="submit">Approve</button>
            </form>
            <?php
            if (isset($_POST["submit"])) {
                $approve = $_POST['approve'];
                $issue = $_POST['issue'];
                $return = $_POST['return'];
                $username = $_SESSION['username'];
                $books_id = $_SESSION['books_id']; // Assuming books_id is stored in $_SESSION['bid']

                // Establish database connection
                $conn = mysqli_connect("localhost", "root", "", "readify_lms");

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Update issue_book table

                $sql = "UPDATE issue_book SET approve='$approve', issue='$issue', `return`='$return' WHERE username='$username' AND books_id='$books_id';";
                if (mysqli_query($conn, $sql)) {
                    // Update library_books table
                    $sql = "UPDATE library_books SET quantity = quantity-1 WHERE books_id='$books_id'";
                    mysqli_query($conn, $sql);

                    // Check quantity and update status
                    $res = mysqli_query($conn, "SELECT quantity FROM library_books WHERE books_id='$books_id'");
                    $row = mysqli_fetch_assoc($res);
                    if ($row['quantity'] == 0) {
                        mysqli_query($conn, "UPDATE library_books SET status='not-available' WHERE books_id='$books_id'");
                    }

                    echo '<script>alert("Updated Successfully"); window.location="request.php";</script>';
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }

                mysqli_close($conn);
            }
            ?>
        </div>
    </div>
</body>

</html>
