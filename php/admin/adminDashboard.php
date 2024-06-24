<?php
include "./adminNavbar.php";
require_once "../config.php";

// Check if the login success message has been shown before
if (!isset($_SESSION['login_success_shown'])) {
    $_SESSION['msg'] = "Welcome Admin!"; // Set the session message
    $_SESSION['msg_code'] = "success";

    //to indicate that the message has been shown
    $_SESSION['login_success_shown'] = true;
}




// Execute the SQL query to count the number of user_ids in the library_users table
$sql = "SELECT COUNT(user_id) AS user_count FROM library_users";

$result = mysqli_query($conn, $sql); // assuming you're using MySQLi

// Check if the query executed successfully
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $user_count = $row['user_count'];

} else {
    // Handle error if the query fails
    $user_count = "Error retrieving user count: " . mysqli_error($conn);

}

// Execute the SQL query to sum up the book quantities in the library_books table
$sqlbook = "SELECT SUM(quantity) AS total_quantity FROM library_books";
$result_book = mysqli_query($conn, $sqlbook); // Execute the query

// Check if the query executed successfully
if ($result_book) {
    $row_book = mysqli_fetch_assoc($result_book);
    $total_quantity = $row_book['total_quantity'];
} else {
    // Handle error if the query fails
    $total_quantity = "Error retrieving book quantity: " . mysqli_error($conn);
}




// Execute the SQL query to count approve books
$sqlapprove = "SELECT COUNT(username) AS approve_count
FROM issue_book
WHERE approve = ''";
$approve_book = mysqli_query($conn, $sqlapprove); // Execute the query

// Check if the query executed successfully
if ($approve_book) {
    $row_book = mysqli_fetch_assoc($approve_book);
    $approve_count = $row_book['approve_count'];
} else {
    // Handle error if the query fails
    $approve_count = "Error retrieving book quantity: " . mysqli_error($conn);
}




// Execute the SQL query to count Expired books
$sqlexpired = "SELECT COUNT( username) AS expired_count
FROM issue_book
WHERE approve = 'Expired'";
$expired_book = mysqli_query($conn, $sqlexpired); // Execute the query

// Check if the query executed successfully
if ($expired_book) {
    $row_book = mysqli_fetch_assoc($expired_book);
    $expired_count = $row_book['expired_count'];
} else {
    // Handle error if the query fails
    $expired_count = "Error retrieving book quantity: " . mysqli_error($conn);
}



// Execute the SQL query to count Fine
$sqlfine = "SELECT COUNT(username) AS fine_count
FROM fine
WHERE status = 'unpaid'";
$fine_book = mysqli_query($conn, $sqlfine); // Execute the query

// Check if the query executed successfully
if ($fine_book) {
    $row_book = mysqli_fetch_assoc($fine_book);
    $fine_count = $row_book['fine_count'];
} else {
    // Handle error if the query fails
    $fine_count = "Error retrieving book quantity: " . mysqli_error($conn);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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

            <div class="dashboard-wrapper d-flex flex-column gap-5">

                <!-- ==== Content Top ===== -->
                <div class="content-book mt-2">

                    <h2>Books Information</h2>
                    <small>Track and Update Book Information</small>

                    <div class="admin-dashboard-actions">
                        <div class="primary-action">
                            <h5 style="font-size: 2.8rem;">Total Books</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;">
                                <b>
                                    <?php echo $total_quantity; ?>
                                </b> Books in Inventory
                            </span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="./viewBook.php" class="btn btn-custom" style='margin-top: 1.2rem;'>View
                                    Details</a>
                                <i class='bx bx-library custom-bx'></i>
                            </div>
                        </div>


                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Approve Book</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>
                                    <?php echo $approve_count; ?>
                                </b>Book requires approval. </span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="Request.php" class="btn btn-custom" style='margin-top: 1.2rem;'>View
                                    Details</a>
                                <i class='bx bx-list-check custom-bx'></i>
                            </div>
                        </div>

                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Expired Books</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>
                                    <?php echo $expired_count; ?>
                                </b> Books have expired</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="./Expired.php" class="btn btn-custom" style='margin-top: 1.2rem;'>View
                                    Details</a>
                                <i class='bx bx-list-minus custom-bx'></i>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==== Content Bottom ==== -->

                <div class="content-user">
                    <h2>Users Information</h2>
                    <small>Track and Interact with Members</small>

                    <div class="admin-dashboard-actions">
                        <div class="primary-action">
                            <h5 style="font-size: 2.8rem;">Total Users</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;">
                                <b>
                                    <?php echo $user_count; ?>
                                </b> Users are signed in
                            </span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="./manageUser.php" class="btn btn-custom" style='margin-top: 1.2rem;'>View
                                    Details</a>
                                <i class='bx bxs-user-account custom-bx'></i>
                            </div>
                        </div>


                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Fine Due</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>
                                    <?php echo $fine_count; ?>
                                </b> users left to pay</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="./fine.php" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class="ri-wallet-3-fill custom-bx"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


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
</body>

</html>