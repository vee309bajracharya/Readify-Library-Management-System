<?php
if (isset($_SESSION['user'])) {
    $fineinfo = 0;
    $expiredBooksCount = 0;
    $expiredFineCharged = 0;

    $exp = '<p> Expired </p>';

    $query = "SELECT `return` FROM issue_book WHERE username ='$_SESSION[user]' AND approve ='$exp'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnDate = date('Y-m-d', strtotime($row['return']));
            $currentDate = date('Y-m-d');
            $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));

            if ($differenceInDays >= 0) {
                if ($differenceInDays > 0) {
                    $expiredBooksCount++;
                    $expiredFineCharged += $differenceInDays * 40;
                }
            }
        }
    }
}
?>