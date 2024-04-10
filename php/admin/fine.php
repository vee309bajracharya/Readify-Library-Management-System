<?php
include "./adminNavbar.php";
require_once "../config.php";

// Function to update the status from unpaid to paid
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $book_id = $_POST["book_id"];

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
            <div class="searchBar__wrapper">
                <h1>Users Fine List</h1>
            </div>
            <div style="margin-top: 2rem;">
                <form method="post">
                        <button type="submit" name="filter" value="all" class="btn btn-default">All information</button>
                        <button type="submit" name="filter" value="unpaid" class="btn btn-default">Unpaid</button>
                        <button type="submit" name="filter" value="paid" class="btn btn-default">Paid</button>
                </form>
            </div>



                <?php
                if (mysqli_num_rows($searchBarQuery) == 0) {
                    echo "<section>";
                    echo "<div class='error_container'>";
                    echo "<img src='../../images/user_not_found.png' alt='User not found image' id='notFound'>";
                    echo "</div>";
                    echo "</section>";
                } else {
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
                    echo "<th>Status</th>";
                    echo "<th>Update Status</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($searchBarQuery)) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['bid'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['returned'] . "</td>";
                        echo "<td>" . $row['days'] . "</td>";
                        echo "<td>" . $row['fine'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='username' value='" . $row['username'] . "'>";
                        echo "<input type='hidden' name='book_id' value='" . $row['bid'] . "'>";
                        echo "<button type='submit' name='submit' class='btn btn-secondary'>Mark as Paid</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                ?>
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