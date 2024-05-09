<?php
if (isset($_SESSION['admin'])) {
    $expiredBooksCount = 0;
    $expiredFineFromIssueBook = 0;
    $expiredFineFromFineTable = 0;

    $exp = 'Expired';

    // Query to fetch return dates from issue_book
    $query = "SELECT `return` FROM issue_book WHERE approve ='$exp'";
    $result = mysqli_query($conn, $query);

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
    $query2 = "SELECT sum(fine) as total_fine FROM fine WHERE book_status ='$exp' AND fine > 0";
    $result2 = mysqli_query($conn, $query2);

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
    $query3 = "SELECT `return` FROM issue_book WHERE username ='$_SESSION[user]' AND approve ='$lost'";
    $result3 = mysqli_query($conn, $query3);

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
    $query4 = "SELECT sum(fine) as total_fine FROM fine WHERE book_status ='$lost'";
    $result4 = mysqli_query($conn, $query4);

    if ($result4) {
        $fineRow = mysqli_fetch_assoc($result4);
        // Add the fine amount from the fine table
        $lostFineFromFineTable = $fineRow['total_fine'];
    }

    // Calculate total fine for lost books
    $totalLostFine = $lostFineFromIssueBook + $lostFineFromFineTable;
}
?>