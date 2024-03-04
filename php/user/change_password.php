<?php
require_once "../config.php";
include "./userNavbar.php";

if (!isset($_SESSION['user'])) {
    header("Location: ./log-in.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/custom_bootstrap.css" />

    <!-- inline css -->
    <style>
        body {
            background-color: var(--white-color);
        }

        .custom-form {
            height: 0%;
        }

        .register__admin {
            width: 48%;
            margin-left: 30rem;
        }
        section{
            padding: 2rem 3rem;
            margin: 0 auto;
            max-width: 1200px;
        }
    </style>



</head>

<body>
    <div id="mySidenav" class="sidenav">
        <div class="logo-container">
            <a href="./list_book_for_user.php">
                <img src="../../svg/logo-1.svg" alt="Readify Logo">
            </a>
        </div>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


        <!-- Profile preview -->
        <div style="margin-top:1.4rem; margin-bottom: 2rem;" class="d-flex flex-column align-items-center text-center">
            <?php
            echo '<div class="custom-links">';
            echo '<img class="img-circle profile_img" width="80" height="80" src="./images/' . $_SESSION['pic'] . '" style="background-color: white; border-radius: 50%; overflow: hidden; margin-right: 10px; object-fit:cover; margin-top:1.3rem;">';
            echo "Welcome," . $_SESSION['user'];
            echo '</div>';
            ?>
        </div>

        <div class="links">
            <a href="./list_book_for_user.php"><i class='bx bxs-dashboard'></i> Dashboard</a>
            <a href="./change_password.php"><i class="ri-lock-password-fill"></i> Change Password</a>
            <a href="./myProfile.php"><i class='bx bxs-user-circle'></i> My Profile</a>
            <a href="#"><i class='bx bxs-book'></i> View Issued Books</a>
            <a href="#"><i class='bx bxs-book'></i> View Archieve Books</a>
            <a href="#"><i class='bx bxs-book'></i> Submit Book Request</a>
            <a href="#"><i class='bx bxs-help-circle'></i> About Readify</a>
            <a href="./logOut.php"><i class="bx bx-log-out"></i> Log out</a>
        </div>

    </div>

    <div id="main">
        <!-- JavaScript for sidebar -->
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


        <!-- change pwd form starts here -->
        <div class="form__container custom-form">
            <div class="form__box custom__box">
                <div class="signup__intro">
                    <h2 style="font-weight: bold; color: #5955E7;">Change Password</h2>
                    <p style="font-size: 1.2rem;">Please enter the password for your account</p>

                </div>

                <form action="./change_password.php" method="POST">

                    <div class="field input">
                        <label for="current_pwd">Current Password</label>
                        <input type="password" name="current_pwd" required>
                    </div>

                    <div class="field input">
                        <label for="new_pwd">New Password</label>
                        <input type="password" name="new_pwd" required>
                    </div>

                    <div class="field input">
                        <label for="confirm_new_pwd">Confirm New Password</label>
                        <input type="password" name="confirm_new_pwd" required>
                    </div>

                    <div class="field">
                        <input type="submit" name="submit" class="btn-primary btn-submit" value="Update Password">

                    </div>


                </form>
            </div>
        </div>


        <!-- update php starts here -->
        <?php
        if (isset($_POST['submit'])) {

            //data validation
            $currentPwd = mysqli_real_escape_string($conn, $_POST['current_pwd']);

            $newPwd = mysqli_real_escape_string($conn, $_POST['new_pwd']);

            $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirm_new_pwd']);

            //check if current pwd is correct

            $username = $_SESSION['user'];

            $query = mysqli_query($conn, "SELECT * FROM library_users WHERE username = '$username'");

            $row = mysqli_fetch_assoc($query);

            if ($row && password_verify($currentPwd, $row['pwd'])) {

                //new pwd validation
                if ($newPwd == $confirmPwd) {
                    $hashPwd = password_hash($newPwd, PASSWORD_DEFAULT);

                    //UPDATE new pwd in database

                    $updateQuery = "UPDATE library_users SET pwd = '$hashPwd' WHERE username = '$username'";

                    if (mysqli_query($conn, $updateQuery)) {
                        echo "<h3 style='color: #0FD76B; font-weight: bold; text-align:center;'>Password updated success!!!!</h3>";
                    } else {
                        echo "Error updating password: " . mysqli_error($conn);
                    }
                } else {
                    echo "<h3 style='color: #f54c46e8; font-weight: bold; text-align:center;'>New password and confirm password do not match!!!</h3>";
                }
            } else {
                echo "<h3 style='color: #f54c46e8; font-weight: bold; text-align:center;'>Current password is incorrect!!!</h3>";
            }
        }


        ?>



    </div>
</body>

</html>