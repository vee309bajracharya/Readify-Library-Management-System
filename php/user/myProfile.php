<?php
require_once "../config.php";
include "./userNavbar.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>

</head>

<body>
    <!-- include Dashboard -->
    <?php
    include "./userDashboard.php";
    ?>


    <div class="list_container">
        <div id="main">

            <div class="profile__wrapper">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM library_users WHERE username = '$_SESSION[user]';");

                if (!$query) {
                    die(mysqli_error($conn)); // Print any error message
                }

                // Check if any rows are returned
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);

                    echo "<div class='row'>";
                    echo "<div class='col-md-4'>";
                    echo "<img class='profile-img' width='300' height='400' style='object-fit:cover; border-radius:10px;' src='./images/" . $_SESSION['pic'] . "'>";
                    echo "</div>";

                    echo "<div class='col-md-8'>";
                    echo "<h4 style='text-align: left; font-size:3rem;'><b>Welcome, </b>" . $_SESSION['user'] . "</h4>";
                    echo "<span class='profileMsg'>Get a sneak peek of your profile</span>";

                    echo "<table style='height:30rem;text-align: left; font-size:1.7rem; color: black;'>";
                    echo "<tr>";
                    echo "<th scope='row'  class='custom-th'>Full Name</th>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row'  class='custom-th'>Username</th>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Email</th>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Phone Number</th>";
                    echo "<td>" . $row['phone_number'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Address</th>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Library Card Number</th>";
                    echo "<td>" . $row['library_card_number'] . "</td>";
                    echo "</tr>";

                    echo "</table>";

                    // Edit button
                    echo "<div style='float:left;'>";
                    echo "<form action='./myProfileEdit.php' method='post'>";
                    echo "<a href='./myProfileEdit.php' class='btn btn-search' name='submit1' style='width: 100%; padding: 10px 15px; margin-top: 10px;'>";
                    echo "<i class='bx bx-edit'></i> Edit Profile";
                    echo "</a>";
                    echo "</form>";
                    echo "</div>";


                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "No user found with the specified username.";
                }
                ?>
            </div>


            <!-- === Bootstrap JavaScript Link==== -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        </div>
    </div>

</body>

</html>