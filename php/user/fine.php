<?php
include "./userNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

// Function to sanitize input to prevent SQL injection
function sanitize_input($conn, $input)
{
    $input = mysqli_real_escape_string($conn, $input);
    $input = htmlspecialchars($input);
    return $input;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fine Details</title>

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

</head>

<body>

    <!-- include Dashboard -->
    <?php
    include "./userDashboard.php";
    ?>

    <div class="list_container">
        <div id="main">
            <h1>Fine Details</h1>

            <?php
            // Get the logged-in user
            $loggedInUser = $_SESSION['user'];

            // Prepare the SQL query to calculate total unpaid and paid fines
            $sql = "
    SELECT 
        SUM(CASE WHEN status = 'unpaid' THEN fine ELSE 0 END) AS totalUnpaidFine,
        SUM(CASE WHEN status = 'paid' THEN fine ELSE 0 END) AS totalPaidFine
    FROM fine 
    WHERE username = '$loggedInUser'";

            // Execute the query
            $result = mysqli_query($conn, $sql);

            // Fetch the result
            $row = mysqli_fetch_assoc($result);

            // Get the total unpaid and paid fines
            $totalUnpaidFine = $row['totalUnpaidFine'];
            $totalPaidFine = $row['totalPaidFine'];


            ?>


            <!-- Display total unpaid fine -->
            <div class="count-amount-container d-flex gap-5 my-5">
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/fine.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-3">Total Unpaid Fine</big> <br>
                        <small class="fw-medium fs-3">Rs.<?php echo $totalUnpaidFine; ?></small>
                    </div>
                </div>
            </div>

            <div class="count-amount-container d-flex gap-5 my-5">
                <div class="custom-sub-container d-flex p-3 gap-2">
                    <div class="place-icon">
                        <img src="../../images/paid.png" class="h-75 m-lg-2">
                    </div>
                    <div class="mt-4">
                        <big class="fw-bold fs-3">Total Paid Fine</big> <br>
                        <small class="fw-medium fs-3">Rs.<?php echo $totalPaidFine; ?></small>
                    </div>
                </div>
            </div>

            <!-- Form for filtering fine information -->


            <div class="searchBar__wrapper">
                <div class="requestBar__wrapper">
                    <form action="" class="navbar-form-c" method="POST">
                        <div class="searchBar_field">
                            <input class="form-control-search" type="text" name="book_name" placeholder="Type Book Name"
                                style="width:100%" required>
                            <button type="submit" name="search" class="btn-search">Search</button>
                        </div>

                    </form>
                </div>
            </div>


            <div class="filter-container d-flex gap-3 float-end">
                <form action="" method="POST" class="my-4">

                    <button type="submit" name="submit1" class="btn btn-default">All Information</button>
                    <button type="submit" name="submit3" class="btn btn-default">Expired</button>
                    <button type="submit" name="submit2" class="btn btn-default">Book Lost</button>
                    <button type="submit" name="submit4" class="btn btn-default">Paid</button>
                    <button type="submit" name="submit5" class="btn btn-default">Unpaid</button>
                </form>

            </div>


            <?php
            // Fetch data for the logged-in user
            if (isset($_SESSION['user'])) {
                $loggedInUser = $_SESSION['user'];

                // Check if search form is submitted
                if (isset($_POST['search'])) {
                    $bookName = sanitize_input($conn, $_POST['book_name']);
                    $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                            FROM fine 
                            INNER JOIN library_books ON fine.bid = library_books.books_id 
                            WHERE fine.username = '$loggedInUser' AND fine.fine > 0 AND library_books.books_name LIKE '%$bookName%'";
                } else {
                    // Determine which button is clicked
                    if (isset($_POST['submit1'])) {
                        // Display all fine information for the logged-in user
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.username = '$loggedInUser' AND fine.fine > 0";

                    } elseif (isset($_POST['submit2'])) {
                        // Display Book Lost information
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.book_status LIKE '%Book Lost%' AND fine.username = '$loggedInUser'";

                    } elseif (isset($_POST['submit3'])) {
                        // Display Expired information
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.book_status LIKE '%Expired%' AND fine.username = '$loggedInUser'";

                    } elseif (isset($_POST['submit4'])) {
                        // Display Paid information
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.status = 'paid' AND fine.username = '$loggedInUser'";

                    } elseif (isset($_POST['submit5'])) {
                        // Display Unpaid information
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.status = 'unpaid' AND fine.username = '$loggedInUser'";

                    } else {
                        // Default to displaying all fine information
                        $sql = "SELECT fine.*, library_books.books_name, library_books.book_cover, fine.book_status
                                FROM fine 
                                INNER JOIN library_books ON fine.bid = library_books.books_id 
                                WHERE fine.username = '$loggedInUser' AND fine.fine > 0";
                    }
                }

                // Execute the SQL query
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div>";
                    echo "<table class='table table-bordered table-hover'>";
                    echo "<tr>";
                    echo "<th>Username</th>";
                    echo "<th>Book ID</th>";
                    echo "<th>Books Name</th>";
                    echo "<th>Book Cover</th>";
                    echo "<th>Returned</th>";
                    echo "<th>Days</th>";
                    echo "<th>Fine</th>";
                    echo "<th>Book Status</th>";
                    echo "<th>Status</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        // Display data from the fine table
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['bid'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['returned'] . "</td>";
                        echo "<td>" . $row['days'] . "</td>";
                        echo "<td>" . $row['fine'] . "</td>";
                        echo "<td>" . $row['book_status'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Session variable 'user' not set.";
            }
            ?>
        </div>
    </div>

</body>

</html>