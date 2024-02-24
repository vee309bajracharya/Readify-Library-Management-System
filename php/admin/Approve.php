<?php
    include "./adminNavbar.php"; // Include the admin navbar
    require_once "../config.php"; // Include the database connection file

    // Fetch pending requests from the database
    $pending_req_query = "SELECT books_id, books_name, authors, edition, status, quantity, department FROM pending_req";
    $pending_req_result = mysqli_query($conn, $pending_req_query);

    // Display pending requests in a table
    if (mysqli_num_rows($pending_req_result) > 0) {
        echo "<div>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        // Table header
        echo "<th>"; echo "Books ID"; echo "</th>";
        echo "<th>"; echo "Books Name"; echo "</th>";
        echo "<th>"; echo "Edition"; echo "</th>";
        echo "<th>"; echo "Authors"; echo "</th>";
        echo "<th>"; echo "Status"; echo "</th>";
        echo "<th>"; echo "Quantity"; echo "</th>";
        echo "<th>"; echo "Department"; echo "</th>";
        echo "<th>"; echo "Action"; echo "</th>";
        echo "</tr>";

        while ($row = mysqli_fetch_assoc($pending_req_result)) {
            echo "<tr>";
            // Fetch data from the pending_req table
            echo "<td>" . $row['books_id'] . "</td>";
            echo "<td>" . $row['books_name'] . "</td>";
            echo "<td>" . $row['edition'] . "</td>";
            echo "<td>" . $row['authors'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['department'] . "</td>";
            echo "<td>";
            // Approve and Decline buttons
            echo "<form action='' method='POST'>";
            echo "<input type='hidden' name='books_id' value='" . $row['books_id'] . "'>";
            echo "<button type='submit' name='approve_req' class='btn btn-success'>Approve</button>";
            echo "<button type='submit' name='decline_req' class='btn btn-danger'>Decline</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "No pending requests found.";
    }

    // Handle approval or decline of requests
    if (isset($_POST['approve_req'])) {
        $books_id = $_POST['books_id'];

        // Update the status for the corresponding books_id
        $update_query = "UPDATE pending_req SET status = 'Approved' WHERE books_id = '$books_id'";
        mysqli_query($conn, $update_query);

        echo "Books ID: $books_id has been approved.";
    }

    if (isset($_POST['decline_req'])) {
        $books_id = $_POST['books_id'];

        // Delete the request with the corresponding books_id
        $delete_query = "DELETE FROM pending_req WHERE books_id = '$books_id'";
        mysqli_query($conn, $delete_query);

        echo "Books ID: $books_id has been declined.";
    }
?>
