<?php
if (isset($_SESSION['user'])) {
    $expiredcount = null;
    $booklostcount = null;

    $expireCountQuery_issue_book = "SELECT COUNT(approve) AS expireCount FROM issue_book WHERE username = '{$_SESSION['user']}' AND approve = 'Expired'";
    $expireCountResult_issue_book = mysqli_query($conn, $expireCountQuery_issue_book);
    $expiredCountRow_issue_book = mysqli_fetch_assoc($expireCountResult_issue_book);
    $expiredCount_issue_book = $expiredCountRow_issue_book['expireCount'];

    $expireCountQuery_fine = "SELECT COUNT(book_status) AS expiredCount FROM fine WHERE username = '{$_SESSION['user']}' AND book_status = 'Expired' AND fine > 0";
    $expireCountResult_fine = mysqli_query($conn, $expireCountQuery_fine);
    $expiredCountRow_fine = mysqli_fetch_assoc($expireCountResult_fine);
    $expiredCount_fine = $expiredCountRow_fine['expiredCount'];

    $totalExpiredCount = $expiredCount_issue_book + $expiredCount_fine;

    $BookLostCountQuery = "SELECT COUNT(approve) AS BookLostCount FROM issue_book WHERE username = '{$_SESSION['user']}' AND approve = 'Book Lost '";
    $BookLostCountResult = mysqli_query($conn, $BookLostCountQuery);
    $BookLostCountRow = mysqli_fetch_assoc($BookLostCountResult);
    $BookLostCount = $BookLostCountRow['BookLostCount'];

    $BooklostountQuery_fine = "SELECT COUNT(book_status) AS BooklostCount FROM fine WHERE username = '{$_SESSION['user']}' AND book_status = 'Book Lost' AND fine > 0";
    $BooklostountResult_fine = mysqli_query($conn, $BooklostountQuery_fine);
    $BooklostCountRow_fine = mysqli_fetch_assoc($BooklostountResult_fine);
    $BooklostCount_fine = $BooklostCountRow_fine['BooklostCount'];

    $totalBookLostCount = $BookLostCount + $BooklostCount_fine;
}
?>