<?php
include "./userNavbar.php";
require_once "../config.php";

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

    <link rel="stylesheet" href="../../css/custom_bootstrap.css" />
    
</head>

<body>

    <!-- include Dashboard -->
    <?php
    include "./userDashboard.php";
    ?>

    <div class="list_container">
        <div id="main">

            <!-- change pwd form starts here -->
            <section class="container-form">
                <div class="form__box custom__box">
                    <div class="signup__intro">
                        <h2 style="font-weight: bold; color: #5955E7;">Change Password</h2>
                        <p style="font-size: 1.2rem;">Update your password below</p>

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
                            <input type="submit" name="submit" class="btn btn-search" value="Update Password" style='width:100%; margin-top:2rem;'>

                        </div>


                    </form>
                </div>
            </section>


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
                            $_SESSION['msg'] = "Password Updated Successfully";
                            $_SESSION['msg_code'] = "success";
                        } else {
                            $_SESSION['msg'] = "Error updating password";
                            $_SESSION['msg_code'] = "error";
                        }
                    } else {
                        $_SESSION['msg'] = "New password and Confirm Password do not match";
                        $_SESSION['msg_code'] = "error";
                    }
                } else {
                    $_SESSION['msg'] = "Current password is incorrect";
                    $_SESSION['msg_code'] = "error";
                }
            }
            ?>
        </div>
    </div>
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