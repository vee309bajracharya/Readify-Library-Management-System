<?php
if (isset($_SESSION['user'])) {
    $fine = 0;

    $exp = '<p> Expired </p>';

    $query = "SELECT `return` FROM issue_book WHERE username ='$_SESSION[user]' AND approve ='$exp'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Convert return date to YYYY-MM-DD format
            $returnDate = date('Y-m-d', strtotime($row['return']));

            // Get the current date in YYYY-MM-DD format
            $currentDate = date('Y-m-d');

            // Print out current date and return date for debugging
            // echo "Current Date: " . $currentDate . "<br>";
            // echo "Return Date: " . $returnDate . "<br>";

            // Calculate the difference in days
            $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));
            // echo "Difference in Days: " . $differenceInDays . "<br>";

            // Check if the difference is non-negative (book is overdue or due today)
            if ($differenceInDays >= 0) {
                // Calculate the fine if overdue
                if ($differenceInDays > 0) {
                    // Calculate the fine
                    $fine += $differenceInDays * 40;

                    // Output the number of days overdue
                    // echo "Number of days overdue: " . $differenceInDays . " days<br>";
                } else {
                    // Book is not overdue
                    // echo "Book is not overdue<br>";
                }
            } else {
                // Book is not overdue
                // echo "Book is not overdue<br>";
            }
        }

        // Output the total fine
        // echo "Total fine: रु॰ " . number_format($fine, 2);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($conn);
    }
}
