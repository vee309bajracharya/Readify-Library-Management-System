<?php
require_once "../config.php";
include "./userNavbar.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>

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
        <!-- 
      <div class="container">
        <form action="" method="post">
            <button class="btn btn-default" name="submit1" style="float:right; width:70px"; >Edit</button>
        </form>
      </div>

      <div class="profile__wrapper">
        <h3>ds</h3>
      </div>
          -->

        <div class="container bootstrap snippets bootdey">
            <div class="panel-body inf-content">
                <div class="row">
                    <div class="col-md-4">
                        <img alt="" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip" src="https://bootdey.com/img/Content/avatar/avatar7.png" data-original-title="Usuario">
                        <ul title="Ratings" class="list-inline ratings text-center">
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <strong>Information</strong><br>
                        <div class="table-responsive">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                Identificacion
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            123456789
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-user  text-primary"></span>
                                                Name
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            Bootdey
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-cloud text-primary"></span>
                                                Lastname
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            Bootstrap
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                                Username
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            bootnipets
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-eye-open text-primary"></span>
                                                Role
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            Admin
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-envelope text-primary"></span>
                                                Email
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            noreply@email.com
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-calendar text-primary"></span>
                                                created
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            20 jul 20014
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-calendar text-primary"></span>
                                                Modified
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            20 jul 20014 20:00:00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
















        <!-- === Bootstrap JavaScript Link==== -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </div>
</body>

</html>