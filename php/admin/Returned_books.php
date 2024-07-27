<?php
include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; // Include database connection file

$searchBarQuery = null; // Set a default value for $searchBarQuery
$dateFilterQuery = null; // Set a default value for $dateFilterQuery

// Check if form is submitted with a username search
if (isset($_POST['search'])) {
    $search_username = $_POST['search_username'];
    // Modify SQL query to filter results by entered username
    $sql = "SELECT * FROM returned_book WHERE username LIKE '%$search_username%'";
    $searchBarQuery = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$searchBarQuery) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    // If no search is performed, fetch all records
    $sql = "SELECT * FROM returned_book";
    $searchBarQuery = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$searchBarQuery) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

// Date-wise filter
$days7 = isset($_POST['days7']);
$days12 = isset($_POST['days12']);
$days24 = isset($_POST['days24']);

$currentDate = date('Y-m-d');
if ($days7) {
    $dateThreshold = date('Y-m-d', strtotime($currentDate . ' - 7 days'));
} elseif ($days12) {
    $dateThreshold = date('Y-m-d', strtotime($currentDate . ' - 12 days'));
} elseif ($days24) {
    $dateThreshold = date('Y-m-d', strtotime($currentDate . ' - 24 days'));
}

if (isset($_POST['filter']) || $days7 || $days12 || $days24) {
    if (isset($_POST['from']) && isset($_POST['to'])) {
        $from = $_POST['from'];
        $to = $_POST['to'];

        // Check if 'to' date is greater than 'from' date
        if (strtotime($to) < strtotime($from)) {
            echo "Please enter a valid date range."; // sweet alert here
            exit;
        }

        // Modify SQL query to filter results by entered from and to date
        $sql = "SELECT * FROM returned_book WHERE issue BETWEEN '$from' AND '$to'";
    } elseif (isset($dateThreshold)) {
        $sql = "SELECT * FROM returned_book WHERE issue >= '$dateThreshold'";
    } else {
        $sql = "SELECT * FROM returned_book";
    }
    $dateFilterQuery = mysqli_query($conn, $sql);

    // Check if query executed successfully
    if (!$dateFilterQuery) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    // If no date filter is applied, use the search query results
    $dateFilterQuery = $searchBarQuery;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books Info</title>
    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <style>
        .requestBar__wrapper {
            margin-bottom: 10px;
        }

        .scroll {
            width: 100%;
            height: 500px;
            overflow: auto;
        }

        th,
        td {
            width: 10%;
        }

    </style>
</head>

<body>
    <!-- include Sidebar -->
    <?php include "./adminSidebar.php"; ?>

    <div class="list_container">
        <div id="main">
            <h2>Returned Books List</h2>

            <!-- searchbar for username -->
            <div class="searchBar__wrapper">
                <form method="post" class="navbar-form-c">
                    <div class="search searchBar_field">
                        <input type="text" class="form-control-search" placeholder="Enter username"
                            name="search_username" style="width:100%;" required>
                        <button class="btn-search" type="submit" name="search">Search</button>
                    </div>
                </form>

                <form method="post">
                    <h4 class="mt-5 fw-bold">Choose Date</h4>
                    <div class="date-filter-container my-2 d-flex gap-5 align">
                        
                        <div class="from-date d-flex flex-column">
                            <label>From</label>
                            <input type="date" class="round-holder"  name="from" value="<?php echo isset($from) ? htmlspecialchars($from) : ''; ?>" i want in this format YYYY-MM-DD
                            required>
                        </div>

                        <div class="to-date d-flex flex-column">
                            <label>To</label>
                            <input type="date" class="round-holder" name="to" value="<?php echo isset($to) ? htmlspecialchars($to) : ''; ?>" i want in this format YYYY-MM-DD
                                required>
                        </div>

                        <div class="date-btn my-5">
                        <button type="submit" name="filter" class="btn-search" style="width: 100%; height:100%;">Search</button>
                    </div>
                    </div>

  


         
                </form>


                <form method="post">
                    <button type="submit" name="all" class="btn btn-default">All</button>
                    <button type="submit" name="days7" class="btn btn-default">7 days</button>
                    <button type="submit" name="days12" class="btn btn-default">12 days</button>
                    <button type="submit" name="days24" class="btn btn-default">24 days</button>
                </form>
            </div>

            <?php
            if (isset($_SESSION["admin"])) {
                // Fetch all records or filtered records based on search and date filter
                if (mysqli_num_rows($dateFilterQuery) > 0) {
                    echo "<div>";
                    echo "<table class='table table-bordered table-hover' style='width:100%;'> ";
                    echo "<tr>";
                    //Table header   
                    echo "<th>User ID</th>";
                    echo "<th>Student Username</th>";
                    echo "<th>Book ID</th>";
                    echo "<th>Books Name</th>";
                    echo "<th>Book Cover</th>";
                    echo "<th>Authors</th>";
                    echo "<th>Book Issued Date</th>";
                    echo "<th>Returned Date</th>";
                    echo "<th>Book Status</th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_assoc($dateFilterQuery)) {
                        // Fetch data from returned_book table
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row['books_id'] . "</td>";
                        echo "<td>" . $row['books_name'] . "</td>";
                        echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='100' style='object-fit: cover; border-radius: 5px;'></td>";
                        echo "<td>" . $row['authors'] . "</td>";
                        echo "<td>" . $row['issue'] . "</td>";
                        echo "<td>" . $row['returned_date'] . "</td>";
                        echo "<td>" . $row['approve'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    // If no records found
                    echo "<div class='error_container'>";
                    echo "<img src='../../images/user_not_found.png' alt='User not found image' id='notFound'>";
                    echo "</div>";
                }
            } else {
                echo "<h3>Please login first</h3>";
            }
            ?>

        </div>
    </div>
</body>

</html>