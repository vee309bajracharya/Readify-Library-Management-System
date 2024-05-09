<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

// Initialize variables to avoid undefined variable warnings
$issueDate = null;
$returnDate = null;
$approveDate = null;
$formattedIssueDate = null;
$formattedReturnDate = null;
$currentDate = date('Y-m-d');

// Fetch issue date based on books_id and username from URL parameters
if (isset($_GET['books_id']) && isset($_GET['username'])) {
    $books_id = $_GET['books_id'];
    $username = $_GET['username'];

    $fetchIssueDateQuery = "SELECT * FROM issue_book WHERE books_id = '$books_id' AND username = '$username'";
    $fetchIssueDateResult = mysqli_query($conn, $fetchIssueDateQuery);

    if ($fetchIssueDateResult && mysqli_num_rows($fetchIssueDateResult) > 0) {
        $issueDateRow = mysqli_fetch_assoc($fetchIssueDateResult);
        $issueDate = $issueDateRow['issue'];
        $returnDate = $issueDateRow['return'];
        $approveDate = $issueDateRow['approve'];

        echo "Issue Date: " . $issueDate;
    } else {
        echo "Issue date not found.";
    }




    if (isset($_POST['Expire'])) {
        // Subtract 6 months from issue and return dates
        $issueDateupdated = date('Y-m-d', strtotime($currentDate . ' -6 months -1 day '));
        $returnDateupdated = date('Y-m-d', strtotime($currentDate . ' -1 day '));
        $approveDate = 'Expired';

        $formattedIssueDate = date('Y-m-d', strtotime($issueDateupdated));
        $formattedReturnDate = date('Y-m-d', strtotime($returnDateupdated));

        $sqlchangedate = "UPDATE issue_book SET issue = '$formattedIssueDate', `return` = '$formattedReturnDate', approve = '$approveDate' WHERE books_id = '$books_id' AND username = '$username'";

        if (mysqli_query($conn, $sqlchangedate)) {
            echo "Dates updated successfully.";
        } else {
            echo "Error updating dates: " . mysqli_error($conn);
        }

    } elseif (isset($_POST['Lost_Book'])) {
        // Subtract 7 months from issue and return dates
        $issueDateupdated = date('Y-m-d', strtotime($currentDate . ' -7 months  -1 day'));
        $returnDateupdated = date('Y-m-d', strtotime($currentDate . ' -1 day '));
        $approveDate = 'Book Lost';

        $formattedIssueDate = date('Y-m-d', strtotime($issueDateupdated));
        $formattedReturnDate = date('Y-m-d', strtotime($returnDateupdated));

        $sqlchangedate = "UPDATE issue_book SET issue = '$formattedIssueDate', `return` = '$formattedReturnDate', approve = '$approveDate' WHERE books_id = '$books_id' AND username = '$username'";

        if (mysqli_query($conn, $sqlchangedate)) {
            echo "Dates updated successfully.";
        } else {
            echo "Error updating dates: " . mysqli_error($conn);
        }

    } elseif (isset($_POST['Approved'])) {
        // Reset issue and return dates to original values
        $issueDateupdated = date('Y-m-d', strtotime('-1 day')); // If issue date is not null, use it; otherwise, use the current date - 1 day
        $returnDateupdated = date('Y-m-d', strtotime('+6 month')); // If return date is not null, use it; otherwise, use the current date + 1 month
        $approveDate = 'Approved';

        $formattedIssueDate = date('Y-m-d', strtotime($issueDateupdated));
        $formattedReturnDate = date('Y-m-d', strtotime($returnDateupdated));

        $sqlchangedate = "UPDATE issue_book SET issue = '$formattedIssueDate', `return` = '$formattedReturnDate', approve = '$approveDate' WHERE books_id = '$books_id' AND username = '$username'";

        if (mysqli_query($conn, $sqlchangedate)) {
            echo "Dates updated successfully.";
        } else {
            echo "Error updating dates: " . mysqli_error($conn);
        }
    } else {
        echo "please choose an option";
    }


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>

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

            <section class="container-form">

                <div class="signup__intro">
                    <h2 style="font-weight: bold; color: #5955E7;">Book Status Changer
                    </h2>
                </div>

                <form method="post">

                    <?php
                    // Display other dates
                    echo "Issued Date: " . $issueDate . "<br>";
                    echo "Return Date: " . $returnDate . "<br>";

                    // Display changed dates
                    echo "Changed Dates";
                    echo "Issued Date: " . $formattedIssueDate . "<br>";
                    echo "Returned Date: " . $formattedReturnDate . "<br>";
                    echo "Approve Date: " . $approveDate . "<br>";
                    ?>

                    <button type="submit" name="Expire">Change to Expired</button>
                    <button type="submit" name="Lost_Book">Change to Book Lost</button>
                    <button type="submit" name="Approved">Change to Approved</button>

                </form>

                <!-- Display the "Change date" button outside of the form -->
                <div class="btn-container">
                    <form method="post">
                        <a href="Expired.php" type="submit" name="Change_date" class="btn btn-primary   ">Back to
                            Book
                            Status</a>
                    </form>
                </div>

            </section>
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