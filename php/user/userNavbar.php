<?php
session_start();

if (!isset ($_SESSION['user'])) {
    header("Location: ./log-in.php"); // Redirect user to login page if not logged in
    exit();
}

include "../config.php"; // Include database connection file
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Readify Library Management System</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css" />

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- ==== RemixIcon link ==== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>

    <!-- ====== navbar starts =========== -->
    <header style='position: sticky !important;top: 0;left: 0;right: 0;z-index: 1000'>
        <nav class="navbar custom-navbar ">
            <div class="container-fluid custom-navbar fixed-top">
                <div class="navbar-header navbar-left">
                    <span onclick="openNav()" class="toggle-trigger custom-toogle-left"
                        style="color: var(--dark-color)">&#9776;</span>
                </div>

                <ul class="nav navbar-nav navbar-right custom-ul navbar-flex">
                    <a href="#"><i class='bx bx-bell'></i></a>
                    <a href="./myProfile.php" style="text-decoration: none;">
                        <?php
                        // Display user's profile image and username if logged in
                        echo '<div class="custom-links d-flex align-items-center">';
                        echo '<img class="img-circle profile_img" width="40" height="40" src="./images/' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover;">';
                        echo '<span class="user" style="color:#000;">' . $_SESSION['user'] . '</span>';
                        echo '</div>';
                        ?>
                    </a>
                </ul>
            </div>
        </nav>

        <?php
        if (isset ($_SESSION['user'])) {
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
                    echo "Current Date: " . $currentDate . "<br>";
                    echo "Return Date: " . $returnDate . "<br>";

                    // Calculate the difference in days
                    $differenceInDays = ceil((strtotime($currentDate) - strtotime($returnDate)) / (60 * 60 * 24));
                    echo "Difference in Days: " . $differenceInDays . "<br>";

                    // Check if the difference is non-negative (book is overdue or due today)
                    if ($differenceInDays >= 0) {
                        // Calculate the fine if overdue
                        if ($differenceInDays > 0) {
                            // Calculate the fine
                            $fine += $differenceInDays * 0.10;

                            // Output the number of days overdue
                            echo "Number of days overdue: " . $differenceInDays . " days<br>";
                        } else {
                            // Book is not overdue
                            echo "Book is not overdue<br>";
                        }
                    } else {
                        // Book is not overdue
                        echo "Book is not overdue<br>";
                    }
                }

                // Output the total fine
                echo "Total fine: रु॰ " . number_format($fine, 2);
            } else {
                // Query failed
                echo "Error: " . mysqli_error($conn);
            }
        }
        ?>
    </header>

    <!-- ====== navbar ends =========== -->
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>