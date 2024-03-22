<?php
include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; //database connection file

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon">

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css">


</head>

<body>

    <!-- include Sidebar -->
    <?php
    include "./adminSidebar.php";
    ?>

    <div class="list_container">
        <div id="main">

            <div class="dashboard-wrapper d-flex flex-column gap-4 ">

                <!-- ==== Content Top ===== -->
                <div class="content-book">

                    <h1>Books Information</h1>
                    <span>Track and Update Book Information</span>

                    <div class="admin-dashboard-actions">

                        <div class="primary-action">
                            <h5 style="font-size: 2.8rem;">Total Books</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>1200</b> Books in Inventory</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class='bx bx-library custom-bx'></i>
                            </div>
                        </div>


                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Approved Books</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>10</b> Books have approved</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class='bx bx-list-check custom-bx'></i>
                            </div>
                        </div>

                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Expired Books</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>19</b> Books have expired</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class='bx bx-list-minus custom-bx'></i>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ==== Content Bottom ==== -->

                <div class="content-user">
                    <h1>Users Information</h1>
                    <span>Track and Interact with Members</span>

                    <div class="admin-dashboard-actions">
                        <div class="primary-action">
                            <h5 style="font-size: 2.8rem;">Total Users</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>50</b> Users are signed in</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class='bx bxs-user-account custom-bx'></i>
                            </div>
                        </div>


                        <div class="primary-action secondary-action">
                            <h5 style="font-size: 2.8rem;">Fine Due</h5>
                            <span style="font-size: 1.9rem; font-weight: 400;"><b>10</b> users left to pay</span>

                            <div class="action-link" style='margin-top: 2rem;'>
                                <a href="" class="btn btn-custom" style='margin-top: 1.2rem;'>View Details</a>
                                <i class="ri-wallet-3-fill custom-bx"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


    </div>
</body>

</html>