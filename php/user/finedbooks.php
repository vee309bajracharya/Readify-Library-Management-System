<?php
if (isset($_SESSION['user'])) {
    $finedBooksCount = 0;
    $totalFineCharged = 0;

    $loggedInUser = $_SESSION['user'];

    $query = "SELECT SUM(fine) AS total_fine, COUNT(*) AS total_books FROM fine WHERE username = '$loggedInUser'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $totalFineCharged = $row['total_fine'];
        $finedBooksCount = $row['total_books'];
    }
}
?>
