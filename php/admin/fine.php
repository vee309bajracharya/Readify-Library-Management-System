<?php
include "./adminNavbar.php";
require_once "../config.php";

// Function to update the status from unpaid to paid
if (isset ($_POST["submit"])) {
    $username = $_POST["username"];
    $book_id = $_POST["book_id"];
    // Assuming you have a function to update the status in your database
    // Replace 'updateStatusFunction' with your actual function name
    $update_query = "UPDATE fine SET status = 'paid' WHERE username = '$username' AND bid = '$book_id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Handle filtering based on status
if (isset ($_POST["filter"])) {
    $status = $_POST["filter"];
    if ($status === "unpaid" || $status === "paid") {
        $sql = "SELECT * FROM fine WHERE status = '$status'";
    } else {
        $sql = "SELECT * FROM fine";
    }
} else {
    $sql = "SELECT * FROM fine";
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
                <h1>List of Users</h1>
                <form action="" class="navbar-form-c" method="POST" name="form-1">
                    <div class="search searchBar_field">
                        <input class="form-control-search" type="text" name="search" placeholder="Search User"
                            style="width:100%" ; required>
                        <button type="submit" name="submit" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
                <form method="post">
                    <button type="submit" name="filter" value="unpaid" class="btn btn-default">Unpaid</button>
                    <button type="submit" name="filter" value="all" class="btn btn-default">All information</button>
                    <button type="submit" name="filter" value="paid" class="btn btn-default">Paid</button>
                </form>


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
                    echo "<th>book id</th>";
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
                        echo "<td>" . $row['returned'] . "</td>";
                        echo "<td>" . $row['days'] . "</td>";
                        echo "<td>" . $row['fine'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='username' value='" . $row['username'] . "'>";
                        echo "<input type='hidden' name='book_id' value='" . $row['bid'] . "'>";
                        echo "<button type='submit' name='submit' class='btn btn-primary'>Mark as paid</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                ?>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        </div>
</body>

</html>