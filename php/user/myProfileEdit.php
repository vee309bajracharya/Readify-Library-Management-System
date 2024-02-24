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

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet">


    <!-- ===== Bootstrap link ======== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- ==== Inline CSS ==== -->


    <style>
        .profile__wrapper {
            text-align: center;
            width: 70%;
            margin-top: 30px;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>

</head>

<body>

    <!-- ====== Sidebar ======== -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

        <a href="./list_book_for_user.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
        <a href="#"><i class="ri-lock-password-fill"></i> Change Password</a>
        <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
        <a href="#"><i class='bx bxs-book'></i> View Issued Books</a>
        <a href="#"><i class='bx bxs-book'></i> View Archieve Books</a>
        <a href="#"><i class='bx bxs-book'></i> Submit Book Request</a>
        <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
        <a href="./logOut.php"><i class="bx bx-log-out"></i> Log out</a>

    </div>

    <div id="main">

        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "300px";
                document.getElementById("main").style.marginLeft = "300px";
                document.body.style.backgroundColor = "white";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.body.style.backgroundColor = "white";
            }
        </script>

        <!-- ==== Sidebar ends here ===== -->

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
                echo "<img class='img-thumbnail' width='300' height='300' src='./images/" . $_SESSION['pic'] . "'>";
                echo "</div>";

                echo "<div class='col-md-8'>";
                echo "<h4><b>Welcome, </b>" . $_SESSION['user'] . "</h4>";

                // Edit form
                echo "<form action='./myProfileEdit.php' method='post' enctype='multipart/form-data'>";
                echo "<table class='table table-bordered table-custom'>";
                echo "<tr>";
                echo "<th scope='row'>Full Name</th>";
                echo "<td><input class='custom-input' type='text' name='fullname' value='" . $row['fullname'] . "'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row'>Username</th>";
                echo "<td><input class='custom-input' type='text' name='username' value='" . $row['username'] . "'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row'>Email</th>";
                echo "<td><input class='custom-input' type='email' name='email' value='" . $row['email'] . "'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row'>Phone Number</th>";
                echo "<td><input class='custom-input' type='tel' name='phone_number' value='" . $row['phone_number'] . "'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<th scope='row'>Address</th>";
                echo "<td><input class='custom-input' type='text' name='address' value='" . $row['address'] . "'></td>";
                echo "</tr>";


                echo "<tr>";
                echo "<th scope='row'>Profile Image</th>";
                echo "<td><input class='custom-input' type='file' name='file'></td>";
                echo "</tr>";
                
                echo "</table>";

                // Submit button
                echo "<div class='text-center'>";
                echo "<button type='submit' class='btn btn-primary' name='submit' style='width: 40%; padding: 10px 15px; margin-top: 10px;'>";
                echo "<i class='bx bx-edit'></i> Update Profile";
                echo "</button>";
                echo "</div>";

                echo "</form>";

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


    <!-- update user information query  -->
    <?php
    if (isset($_POST['submit'])) {

        //for custom image upload 
        move_uploaded_file($_FILES['file']['tmp_name'], "./images/" . $_FILES['file']['name']);



        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $pic = $_FILES['file']['name'];

        // Validate phone number length
        if (strlen($phone_number) == 10) {

            // Validate email format
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


                // Validate username 
                if (preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
                    $sql1 = "UPDATE library_users SET 
                    pic='$pic',
                    fullname='$fullname',
                    username='$username',
                    email='$email',
                    phone_number='$phone_number',
                    address='$address' WHERE username='" . $_SESSION['user'] . "'";

                    if (mysqli_query($conn, $sql1)) {
                        echo "<section class='alert-success-msg'>Update Success!!</section>";
 
                    } else {
                        echo "<section class='alert-error-msg'>Error updating record: " . mysqli_error($conn) . "</section>";
                    }
                } else {
                    echo "<section class='alert-error-msg'>Only alphanumeric characters and underscores are valid</section>";
                }
            } else {
                echo "<section class='alert-error-msg'>Please provide a valid email</section>";
            }
        } else {
            echo "<section class='alert-error-msg'>Invalid phone number length. Please provide a 10-digit phone number</section>";
        }
    }
    ?>




</body>

</html>