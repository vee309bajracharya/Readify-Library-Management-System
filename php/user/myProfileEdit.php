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

    <style>
        .btn-search {
            background-color: var(--primary-color);
            border: 0;
            outline: 0;
            padding: 3rem 10rem;
        }


        .submit-success {
            text-align: center;
            font-weight: bold;
            color: var(--success-msg-color);
            font-size: 2rem;
        }

        .submit-error {
            color: var(--alert-msg-color);
        }

    </style>

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
                    echo "<h4 style='text-align: left; font-size:3rem;'><b>Ready to personalize?</b></h4>";
                    echo "<span class='profileMsg'>Edit your details below</span>";

                    // Edit form
                    echo "<form action='./myProfileEdit.php' method='post' enctype='multipart/form-data'>";
                    echo "<table style='height:30rem;text-align: left; font-size:1.5rem; color: black;'>"; echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Full Name</th>";
                    echo "<td><input class='custom-input' type='text' name='fullname' value='" . $row['fullname'] . "'></td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Username</th>";
                    echo "<td><input class='custom-input' type='text' name='username' value='" . $row['username'] . "'></td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Email</th>";
                    echo "<td><input class='custom-input' type='email' name='email' value='" . $row['email'] . "'></td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Phone Number</th>";
                    echo "<td><input class='custom-input' type='tel' name='phone_number' value='" . $row['phone_number'] . "'></td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Address</th>";
                    echo "<td><input class='custom-input' type='text' name='address' value='" . $row['address'] . "'></td>";
                    echo "</tr>";


                    echo "<tr>";
                    echo "<th scope='row' class='custom-th'>Profile Image</th>";
                    echo "<td><input class='custom-input' type='file' name='file'></td>";
                    echo "</tr>";

                    echo "</table>";



                    // Submit button for Update Profile
                    echo "<button type='submit' class='btn btn-search' name='submit' style='width: 28%; padding: 10px 15px; margin-top: 10px; float:left;'>";
                    echo "<i class='bx bx-edit'></i> Update Profile";
                    echo "</button>";


                    echo "</form>";

                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "No user found with the specified username.";
                }
                ?>
            </div>



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
                            // Update the session variable with the new image filename
                            $_SESSION['pic'] = $pic;
                            $_SESSION['msg'] = 'Profile Updated!!';
                            $_SESSION['msg_code'] = "success";
                        } else {
                            $_SESSION['msg'] = 'Error updating record';
                            $_SESSION['msg_code'] = "error";
                        }
                    } else {
                        $_SESSION['msg'] = 'Only alphanumeric characters and underscores are valid';
                        $_SESSION['msg_code'] = "error";
                    }
                } else {
                    $_SESSION['msg'] = 'Provide a valid email';
                    $_SESSION['msg_code'] = "error";
                }
            } else {
                $_SESSION['msg'] = 'Provide a 10-digit phone number';
                $_SESSION['msg_code'] = "error";
            }
        }
        ?>
    </div>





    <!-- === Bootstrap JavaScript Link==== -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php 
          include ('../sweetAlert/sweetalert_actions.php');
    ?>





</body>
</html>