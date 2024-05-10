<?php
if (isset($_SESSION['admin'])) {
    $expiredBooksCount = 0;
    $expiredFineFromIssueBook = 0;
    $expiredFineFromFineTable = 0;

    $exp = 'Expired';

    // Query to fetch return dates from issue_book
    $query = "SELECT `return` FROM issue_book WHERE approve = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $exp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnDate = date('Y-m-d', strtotime($row['return']));
            $currentDate = date('Y-m-d');
            $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));

            if ($differenceInDays > 0) {
                $expiredBooksCount++;
                // Calculate fine charged based on the difference in days
                $expiredFineFromIssueBook += $differenceInDays * 40;
            }
        }
    }

    // Query to fetch fines from the fine table
    $query2 = "SELECT sum(fine) as total_fine FROM fine WHERE book_status = ? AND fine > 0";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "s", $exp);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    if ($result2) {
        $fineRow = mysqli_fetch_assoc($result2);
        // Add the fine amount from the fine table
        $expiredFineFromFineTable = $fineRow['total_fine'];
    }

    // Calculate total fine for expired books
    $totalExpiredFine = $expiredFineFromIssueBook + $expiredFineFromFineTable;

    $lostBooksCount = 0;
    $lostFineFromIssueBook = 0;
    $lostFineFromFineTable = 0;

    $lost = 'Book Lost';

    // Query to fetch return dates from issue_book
    $query3 = "SELECT `return` FROM issue_book WHERE username = ? AND approve = ?";
    $stmt3 = mysqli_prepare($conn, $query3);
    mysqli_stmt_bind_param($stmt3, "ss", $_SESSION['user'], $lost);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);

    if ($result3) {
        while ($row = mysqli_fetch_assoc($result3)) {
            $returnDate = date('Y-m-d', strtotime($row['return']));
            $currentDate = date('Y-m-d');
            $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));

            if ($differenceInDays > 0) {
                $lostBooksCount++;
                // Calculate fine charged based on the difference in days
                $lostFineFromIssueBook += 5000;
            }
        }
    }

    // Query to fetch fines from the fine table
    $query4 = "SELECT sum(fine) as total_fine FROM fine WHERE book_status = ?";
    $stmt4 = mysqli_prepare($conn, $query4);
    mysqli_stmt_bind_param($stmt4, "s", $lost);
    mysqli_stmt_execute($stmt4);
    $result4 = mysqli_stmt_get_result($stmt4);

    if ($result4) {
        $fineRow = mysqli_fetch_assoc($result4);
        // Add the fine amount from the fine table
        $lostFineFromFineTable = $fineRow['total_fine'];
    }

    // Calculate total fine for lost books
    $totalLostFine = $lostFineFromIssueBook + $lostFineFromFineTable;
}
?>
