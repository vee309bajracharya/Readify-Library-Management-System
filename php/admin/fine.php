<?php
include "./adminNavbar.php";
require_once "../config.php";
include "fineinfo.php";
// Function to update the status from unpaid to paid
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $book_id = $_POST["book_id"];

    // $addquantity = "UPDATE library_books SET quantity = quantity + 1 WHERE books_id = $books_id";
    $update_query = "UPDATE fine SET status = 'paid' WHERE username = '$username' AND bid = '$book_id'";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        $_SESSION['msg'] = "Status Updated Successfully!!";
        $_SESSION['msg_code'] = "success";
    } else {
        $_SESSION['msg'] = "Error updating status";
        $_SESSION['msg_code'] = "error";
    }
}

// Handle filtering based on status
if (isset($_POST["filter"])) {
    $status = $_POST["filter"];
    if ($status === "unpaid" || $status === "paid") {
        $sql = "SELECT fine.*,
        library_books.books_name,
        library_books.book_cover 
        FROM fine INNER JOIN library_books
        ON fine.bid = library_books.books_id WHERE fine.status = '$status'";
    } else {
        $sql = "SELECT fine.*,
        library_books.books_name,
        library_books.book_cover 
        FROM fine INNER JOIN library_books 
        ON fine.bid = library_books.books_id";
    }
} else {
    $sql = "SELECT fine.*,
    library_books.books_name,
    library_books.book_cover
    FROM fine INNER JOIN library_books
    ON fine.bid = library_books.books_id";
}

$searchBarQuery = mysqli_query($conn, $sql);

if (!$searchBarQuery) {
    echo "Error: " . mysqli_error($conn);
    exit;
}


$expireCountQuery_issue_book = "SELECT COUNT(approve) AS expireCount FROM issue_book WHERE approve = 'Expired'";
$expireCountResult_issue_book = mysqli_query($conn, $expireCountQuery_issue_book);
$expiredCountRow_issue_book = mysqli_fetch_assoc($expireCountResult_issue_book);
$expiredCount_issue_book = $expiredCountRow_issue_book['expireCount'];

$expireCountQuery_fine = "SELECT COUNT(book_status) AS expiredCount FROM fine WHERE book_status = 'Expired' AND fine > 0";
$expireCountResult_fine = mysqli_query($conn, $expireCountQuery_fine);
$expiredCountRow_fine = mysqli_fetch_assoc($expireCountResult_fine);
$expiredCount_fine = $expiredCountRow_fine['expiredCount'];

$totalExpiredCount = $expiredCount_issue_book + $expiredCount_fine;


$BookLostCountQuery = "SELECT COUNT(approve) AS BookLostCount FROM issue_book WHERE approve = 'Book Lost '";
$BookLostCountResult = mysqli_query($conn, $BookLostCountQuery);
$BookLostCountRow = mysqli_fetch_assoc($BookLostCountResult);
$BookLostCount = $BookLostCountRow['BookLostCount'];

$BooklostountQuery_fine = "SELECT COUNT(book_status) AS BooklostCount FROM fine WHERE book_status = 'Book Lost' AND fine > 0";
$BooklostountResult_fine = mysqli_query($conn, $BooklostountQuery_fine);
$BooklostCountRow_fine = mysqli_fetch_assoc($BooklostountResult_fine);
$BooklostCount_fine = $BooklostCountRow_fine['BooklostCount'];


$totalBookLostCount = $BookLostCount + $BooklostCount_fine;




// Count pending fines and calculate sum
$pendingFineQuery = "SELECT COUNT(status) AS PendingFineCount, SUM(fine) AS PendingFineSum FROM fine WHERE status = 'unpaid'";
$pendingFineResult = mysqli_query($conn, $pendingFineQuery);
$pendingFineRow = mysqli_fetch_assoc($pendingFineResult);
$pendingFineCount = $pendingFineRow['PendingFineCount'];
$pendingFineSum = $pendingFineRow['PendingFineSum'];

// Count paid fines and calculate sum
$paidFineQuery = "SELECT COUNT(status) AS PaidFineCount, SUM(fine) AS PaidFineSum FROM fine WHERE status = 'paid'";
$paidFineResult = mysqli_query($conn, $paidFineQuery);
$paidFineRow = mysqli_fetch_assoc($paidFineResult);
$paidFineCount = $paidFineRow['PaidFineCount'];
$paidFineSum = $paidFineRow['PaidFineSum'];
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Calculation</title>
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">
</head>

<body>
    <?php include "./adminSidebar.php"; ?>

    <div class="list_container">
        <div id="main">
            <h2>Users Fine List</h2>
            <!-- Book expired -->
            <div class="count-amount-container d-flex gap-5 my-5">
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/expired.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-4"><?php echo $totalExpiredCount; ?> Books Expired</big> <br>
                        <small>Total Expired Books Fine Rs.<?php echo $totalExpiredFine; ?></small>
                    </div>
                </div>

                <!-- Book lost -->
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/lost.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-4"><?php echo $totalBookLostCount; ?> Books Lost</big> <br>
                        <small>Total Books Lost Fine Rs.<?php echo $totalLostFine; ?></small>
                    </div>
                </div>

                <!-- Unpaid amt -->
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/Pendingfine.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-4"><?php echo $pendingFineCount; ?> Unpaid fines</big> <br>
                        <small>Rs.<?php echo $pendingFineSum; ?></small>
                    </div>
                </div>
                <!-- Paid amt -->
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/paid.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-4"><?php echo $paidFineCount; ?> Paid Fines</big> <br>
                        <small>Rs.<?php echo $paidFineSum; ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- searchbar for username -->
        <div class="searchBar__wrapper my-3">
            <form method="post" class="navbar-form-c">
                <div class="search searchBar_field">
                    <input type="text" class="form-control-search" placeholder="Enter username" name="search_username"
                        style="width:100%" ; required>
                    <button class="btn-search" type="submit" name="search">Search</button>
                </div>
            </form>
        </div>

        <!-- filters -->
        <form method="post">
            <div class="filter-container d-flex gap-3 float-end">
                <button class="btn btn-default" type="submit" name="filter_all">All</button>
                <button class="btn btn-default" type="submit" name="filter_expired">Expired</button>
                <button class="btn btn-default" type="submit" name="filter_lost">Book Lost</button>
                <button class="btn btn-default" type="submit" name="filter_unpaid">Unpaid</button>
                <button class="btn btn-default" type="submit" name="filter_paid">Paid</button>
            </div>
        </form>


        <?php
        // Check if form is submitted with a username
        if (isset($_POST['search_username'])) {
            $search_username = $_POST['search_username'];
            // Modify SQL query to filter results by entered username
            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
            WHERE fine.username = '$search_username'";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        }

        // Check if form is submitted to filter by "Expired" books
        if (isset($_POST['filter_expired'])) {
            // Modify SQL query to filter results by book_status 'Expired'
            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
            WHERE fine.book_status = 'Expired'";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        }
        // Check if form is submitted to filter by "Expired" books
        if (isset($_POST['filter_unpaid'])) {
            // Modify SQL query to filter results by book_status 'Expired'
            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
            WHERE fine.status = 'unpaid'";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        }
        // Check if form is submitted to filter by "Expired" books
        if (isset($_POST['filter_paid'])) {
            // Modify SQL query to filter results by book_status 'Expired'
            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
            WHERE fine.status = 'paid'";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }
        }

        // Check if form is submitted to filter by "Book Lost" books
        if (isset($_POST['filter_lost'])) {
            // Modify SQL query to filter results by book_status 'Book Lost'
            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
            WHERE fine.book_status = 'Book Lost'";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }


        }



        if (isset($_POST['filter_all'])) {

            $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover
            FROM fine
            INNER JOIN library_books ON fine.bid = library_books.books_id
  ";
            $searchBarQuery = mysqli_query($conn, $sql);

            // Check if query executed successfully
            if (!$searchBarQuery) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }


        }
        ?>

        <!-- Display the information for the entered username -->
        <?php
        if (isset($searchBarQuery) && mysqli_num_rows($searchBarQuery) > 0) {
            // Display the table with filtered results
            echo "<div>";
            echo "<table class='table table-bordered table-hover'>";
            // Table headers
            echo "<tr>";
            echo "<th>Username</th>";
            echo "<th>Book ID</th>";
            echo "<th>Books Name</th>";
            echo "<th>Book Cover</th>";
            echo "<th>Returned</th>";
            echo "<th>Days</th>";
            echo "<th>Fine</th>";
            echo "<th>Status</th>";
            echo "<th>Book Status</th>";
            echo "<th>Update Status</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                // Table rows for each record
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['bid'] . "</td>";
                echo "<td>" . $row['books_name'] . "</td>";
                echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                echo "<td>" . $row['returned'] . "</td>";
                echo "<td>" . $row['days'] . "</td>";
                echo "<td>" . $row['fine'] . "</td>";
                echo "<td>" . $row['book_status'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";

                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='username' value='" . $row['username'] . "'>";
                echo "<input type='hidden' name='book_id' value='" . $row['bid'] . "'>";
                echo "<button type='submit' name='submit' class='btn btn-action'>Mark as Paid</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } elseif (isset($searchBarQuery) && mysqli_num_rows($searchBarQuery) == 0) {
            // If no records found for the entered username
            echo "<section>";
            echo "<div class='error_container'>";
            echo "<img src='../../images/user_not_found.png' alt='User not found image' id='notFound'>";
            echo "</div>";
            echo "</section>";
        }
        ?>

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