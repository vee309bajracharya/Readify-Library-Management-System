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
    <title>About Readify</title>

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
        section{
            padding: 2rem 3rem;
            margin: 0 auto;
            max-width: 1200px;
        }

        .about_container {
            display: grid;
            place-items: center;
            padding: 3rem;
            background-color: var(--hover-color1);
            box-shadow: var(--box-shadow-color);
            color: var(--white-color);
            border-radius: 10px;
        }

        .about_container .logo__container img {
            width: 200px;
            float: center;
        }
        .about_container p {
            margin-bottom: 20px;
            font-size: 1.5rem;
            text-align: justify;
            line-height: 1.6;
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
            <a href="./issue_info.php"><i class='bx bxs-book'></i> View Issued Books</a>
            <a href="#"><i class='bx bxs-book'></i> View Archive Books</a>
            <a href="./Request.php"><i class='bx bxs-book'></i>Book Request</a>
            <a href="./about_readify.php"><i class='bx bxs-help-circle'></i> About Readify</a>
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

        <section class="container-fluid">
            <div class="about_container">
                <div class="logo__container">
                    <img src="../../svg/logo-1.svg" alt="Readify Image">
                </div>



                <p>
                    Readify is an innovative software solution designed to transform your library experience. At Readify,
                    we've created a platform with the user in mind, focusing on simplicity, accessibility, and efficiency.
                </p>

                <p>
                    Our primary mission is to streamline the borrowing process, making it quicker and more convenient for users.
                    Readify aims to bridge the gap between library resources and users by providing a user-friendly online
                    interface, ensuring a seamless and enjoyable experience.
                </p>
    

                <p>
                    Readify's user interface is crafted for ease of use. With just a few clicks, users can access a wealth of
                    information about available books, empowering them to make informed decisions. The intuitive design ensures
                    that even those unfamiliar with library systems can navigate effortlessly.
                </p>

                <p>
                    One of Readify's key features is its ability to expedite the book borrowing process. Users can search for
                    books, check availability, and borrow items from the comfort of their homes. This streamlined approach not
                    only saves time but also enhances the overall efficiency of library operations.
                </p>

                <p>
                    Readify goes beyond borrowing by helping users manage their library activities effectively. The system allows
                    users to monitor due dates for borrowed books, reducing the likelihood of late returns. This comprehensive
                    approach ensures that Readify is not just a borrowing platform but a tool for organized and efficient library
                    engagement. Welcome to the future of library services with Readify!
                </p>
            </div>
        </section>











    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>