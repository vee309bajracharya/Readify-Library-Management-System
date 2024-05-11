<?php
include "./adminNavbar.php";
require_once "../config.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Book status</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <style>
        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            border-radius: 15px;
        }
        .btn-circle.btn-lg {
            width: 50px;
            height: 50px;
            padding: 10px 13px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 25px;
            display: flex;
            align-items: center;
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

        <div>
            <form method="post">
                <a href="Expired.php" type="submit" name="Change_date" class="btn btn-default btn-circle btn-lg" alt="Back to Book Status"><i class='bx bx-arrow-back' style='text-align:center;'></i></a>
            </form>
        </div>

            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);



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
                        $_SESSION['msg'] = "Date Updated Successfully";
                        $_SESSION['msg_code'] = "success";
                    } else {
                        $_SESSION['msg'] = "Error updating dates";
                        $_SESSION['msg_code'] = "error";
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
                        $_SESSION['msg'] = "Date Updated Successfully";
                        $_SESSION['msg_code'] = "success";
                    } else {
                        $_SESSION['msg'] = "Error updating dates";
                        $_SESSION['msg_code'] = "error";
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
                        $_SESSION['msg'] = "Date Updated Successfully";
                        $_SESSION['msg_code'] = "success";
                    } else {
                        $_SESSION['msg'] = "Error updating dates";
                        $_SESSION['msg_code'] = "error";
                    }
                }
            }
            ?>

                <section class="container-form">
                    <div class="form__box custom__box w-75">
                        <div class="signup__intro">
                            <h2 style="font-weight: bold; color: #5955E7;">Book Status Changer</h2>
                        </div>

                <form method="post">
                        <div class="field input">
                            <big class="fw-bold fs-3">Issued Date: </big>
                            <small class="fs-3"><?php echo "$issueDate" ?></small>
                        </div>

                        <div class="field input">
                            <big class="fw-bold fs-3">Return Date: </big>
                            <small class="fs-3"><?php echo "$returnDate" ?></small>
                        </div>
                        
                    <label for="changedDates" class="fw-semibold my-4">Changed Dates : </label> <br>

                        <div class="field input">
                            <big class="fw-bold fs-3">Issued Date: </big>
                            <small class="fs-3"><?php echo "$formattedIssueDate" ?></small>
                        </div>

                        <div class="field input">
                            <big class="fw-bold fs-3">Returned Date: </big>
                            <small class="fs-3"><?php echo "$formattedReturnDate" ?></small>
                        </div>

                        <div class="field input">
                            <big class="fw-bold fs-3">Status: </big>
                            <small class="fs-3"><?php echo "$approveDate" ?></small>
                        </div>


                    <div class="my-4">
                        <button type="submit" name="Expire" class="btn btn-default">Change to Expired</button>
                        <button type="submit" name="Lost_Book" class="btn btn-default">Change to Book Lost</button>
                        <button type="submit" name="Approved" class="btn btn-default">Change to Approved</button>
                    </div>

                </form>

                </div>
                </section>
        </div>
    </div>

    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
        include('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>