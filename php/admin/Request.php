<?php
include "./adminNavbar.php";
require_once "../config.php";

// Process approval if approve_book_id is set
if (isset($_GET['approve_book_id'])) {
    // Check if any book is selected for approval
    if (isset($_GET['approve_books_id']) && is_array($_GET['approve_books_id'])) {
        foreach ($_GET['approve_books_id'] as $approve_books_id) {
            // Get the book ID and username from the value of checkbox
            list($books_id, $username) = explode('_', $approve_books_id);
            $approve_books_id = mysqli_real_escape_string($conn, $books_id);
            $approve_username = mysqli_real_escape_string($conn, $username);

            // Check if the quantity of the book is greater than 0
            $quantity_check_query = "SELECT quantity FROM library_books WHERE books_id = '$approve_books_id'";
            $quantity_check_result = mysqli_query($conn, $quantity_check_query);
            $row = mysqli_fetch_assoc($quantity_check_result);
            $quantity = $row['quantity'];

            if ($quantity > 0) {
                // Calculate the issue and return dates
                $issue_date = date('Y-m-d'); // Current date
                $return_date = date('Y-m-d', strtotime($issue_date . ' + 6 months')); // Return date after 6 months

                $approve = "Yes"; // Assuming this is the status when a book is approved

                // Update the entry in the issue_book table
                $approve_query = "UPDATE issue_book SET approve = '$approve', issue = '$issue_date', `return` = '$return_date' WHERE books_id = '$approve_books_id' AND username = '$approve_username'";

                // Decrement the quantity in the library_books table
                $decrement_query = "UPDATE library_books SET quantity = quantity - 1 WHERE books_id = '$approve_books_id'";

                // Execute both queries
                if (mysqli_query($conn, $approve_query) && mysqli_query($conn, $decrement_query)) {
                    // Set session variables for success message (optional)
                    $_SESSION['msg'] = "Approved successfully";
                    $_SESSION['msg_code'] = "success";
                } else {
                    // Set session variables for error message (optional)
                    $_SESSION['msg'] = "Book(s) Not approved";
                    $_SESSION['msg_code'] = "error";
                }
            } else {
                // Set session variables for error message (optional)
                $_SESSION['msg'] = "Book(s) not available";
                $_SESSION['msg_code'] = "error";
            }
        }
    } else {
        // Set session variables for error message (optional)
        $_SESSION['msg'] = "No books selected for approval";
        $_SESSION['msg_code'] = "error";
    }

    // Redirect to prevent resubmission
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Books list</title>

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
            <h2>Incoming Book Request</h2>

            <form action="" class="navbar-form-c" method="POST" name="form-1">
                <div class="searchBar_field">
                    <input class="form-control-search" type="text" name="username" placeholder="Username"
                        style="width:100%" required>
                    <input type="text" name="book_id" class="form-control-search" placeholder="books_id"
                        style="width:100%" required>
                    <button type="submit" name="submit" class="btn-search">Process Request</button>
                </div>
            </form>

            <form action="" method="get">
                <button type="submit" name="approve_book_id" class="btn btn-default">Approve Selected</button>
                <button type="button" onclick="checkAll()" class="btn btn-default">Check All</button>
                <button type="button" onclick="uncheckAll()" class="btn btn-default">Uncheck All</button>

                <?php
                if (isset($_SESSION['admin'])) {
                    $sql = "SELECT 
                            library_users.fullname, 
                            library_users.username, 
                            library_users.user_id, 
                            issue_book.books_id, 
                            library_books.books_name,
                            library_books.book_cover,
                            library_books.authors, 
                            library_books.edition, 
                            library_books.status ,
                            library_books.quantity
                        FROM 
                            library_users 
                        INNER JOIN 
                            issue_book ON library_users.username = issue_book.username 
                        INNER JOIN 
                            library_books ON issue_book.books_id = library_books.books_id 
                        WHERE 
                            issue_book.approve = ''";

                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) == 0) {
                        echo "<section>";
                        echo "<div class='error_container'>";
                        echo "<img src='../../images/no_pending_req.png' alt='No pending request image' id='notFound'>";
                        echo "</div>";
                        echo "</section>";
                    } else {
                        echo "<div>";
                        echo "<table class='table table-bordered table-hover'>";
                        echo "<tr>";
                        //Table header
                
                        echo "<th>";
                        echo "User ID";
                        echo "</th>";

                        echo "<th>";
                        echo "Student's Name";
                        echo "</th>";

                        echo "<th>";
                        echo "Book ID";
                        echo "</th>";

                        echo "<th>";
                        echo "Books Name";
                        echo "</th>";

                        echo "<th>";
                        echo "Book Cover";
                        echo "</th>";

                        echo "<th>";
                        echo "Authors";
                        echo "</th>";

                        echo "<th>";
                        echo "Edition";
                        echo "</th>";

                        echo "<th>";
                        echo "Quantity";
                        echo "</th>";

                        echo "<th>";
                        echo "Action";
                        echo "</th>";

                        echo "</tr>";
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr>";
                            //fetch data from issue_book table
                
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";

                            echo "<td>" . $row['books_id'] . "</td>";
                            echo "<td>" . $row['books_name'] . "</td>";
                            echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                            echo "<td>" . $row['authors'] . "</td>";
                            echo "<td>" . $row['edition'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";

                            echo "<td>";
                            if (isset($_SESSION['admin'])) {
                                // Check if the user has already requested this book
                                $username = $row['username']; // Remove $ from $username
                                $books_id = $row['books_id']; // Remove $ from $books_id
                                $existing_request_query = "SELECT * FROM issue_book WHERE username = '$username' AND books_id = '$books_id'";
                                $existing_request_result = mysqli_query($conn, $existing_request_query);

                                if ($existing_request_result && mysqli_num_rows($existing_request_result) > 0) {
                                    // Book is already requested by the user, display the approve button
                                    echo "<input type='checkbox' name='approve_books_id[]' value='" . $row['books_id'] . "_" . $row['username'] . "' id='approveCheckbox' class='btn bg-info text-bg-info'></input>";
                                } else {
                                    // Book is not requested by the user, display a message
                                    echo "<p>Already Requested</p>";
                                }
                            } else {
                                // User not logged in
                                echo "Login to Request";
                            }
                            echo "</td>";

                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
                } else {
                    ?>
                    <?php
                    $_SESSION['msg'] = "Login First !!";
                    $_SESSION['msg_code'] = "error";
                    ?>

                    <?php
                }
                ?>
            </form>
        </div>
    </div>

    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
    include ('../sweetAlert/sweetalert_actions.php');
    ?>
    <script>
        function checkAll() {
            var checkboxes = document.getElementsByName('approve_books_id[]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        }

        function uncheckAll() {
            var checkboxes = document.getElementsByName('approve_books_id[]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        }
    </script>
</body>

</html>