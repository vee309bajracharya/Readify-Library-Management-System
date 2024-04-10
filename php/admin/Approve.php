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

    <style>

        .approve{
            width: 60%;
        }
        .approve_button {
            margin-top: 3rem;
            text-align: center;
            height: 4rem;
            width: 20rem;
            color: white;
            background-color: var(--primary-color);
            border-radius: 0.5rem;
            border: none;
        }

    </style>
</head>

<body>

    <!-- include Sidebar -->
    <?php
    include "./adminSidebar.php";
    ?>

    <div class="list_container">
        <div id="main">

        <section class="container-form">
                <div class="form__box custom__box">

                    <div class="signup__intro">
                        <h2 style="font-weight: bold; color: #5955E7;">Approve <br> Book Request</h2>

                    </div>

                    <form action="" method="post" style="margin-top: 5rem;">

                    <div class="field input">
                            <label for="bookApprove">Approve Book</label>
                            <input type="text" name="approve" placeholder="Yes" required>
                    </div>

                    <div class="field input">
                            <label for="issueDate">Book Issue Date</label>
                            <input type="date" name="issue" placeholder="yyyy-mm-dd" required>
                    </div>

                    <div class="field input">
                            <label for="returnDate">Book Return Date</label>
                            <input type="date" name="return" placeholder="yyyy-mm-dd" required><br>
                    </div>

                    <div class="btn-container">
                            <button class="approve_button" type="submit" name="submit">Approve</button>
                        </div>

                    </form>
                </div>
        </section>


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

                        $_SESSION['msg'] = "Book Approved !!";
                        $_SESSION['msg_code'] = "success";
                    } else {
                        $_SESSION['msg'] = "Error in Approving book !!";
                        $_SESSION['msg_code'] = "error";
                    }

                    mysqli_close($conn);
                }
                ?>
            </div>
        </div>
        <!-- jquery, popper, bootstrapJS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php 
          include ('../sweetAlert/sweetalert_actions.php');
    ?>
</body>
</html>