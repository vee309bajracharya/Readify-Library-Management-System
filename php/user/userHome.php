<?php 
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: ./log-in.php"); //if user isn't registered , take it to login page
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Panel</title>
    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

    <!-- CSS Links -->
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/responsive.css" />

    <!-- ==== Google Fonts Link ==== -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800;900&family=Montserrat:wght@400;500;600;700;800;900&family=Nunito:wght@300;400;500;600;700;800&family=Poppins:wght@100;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- ==== Boxicons link ==== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

    
    <!-- Material Icon Link -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
</head>

<body>


<!-- === for page layout ===  -->
<div class="dashboard__grid__wrapper">
    <!-- === page header starts === -->
    <header class="sub__header">
      <div class="header__left">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined"> menu </span>
        </div>
      </div>

      <div class="header__right">
        <span class="material-icons-outlined"> notifications </span>
        <span class="material-icons-outlined"> account_circle </span>
      </div>
    </header>
    <!-- === page header ends === -->

    <!-- ====  Sidebar ===== -->
    <aside class="sidebar" id="sidebar">
      <div class="readify-logo">
        <img src="../../svg/logo-1.svg" alt="Logo" />
      </div>
      <span class="material-icons-outlined" onclick="closeSidebar()">
        close
      </span>

      <ul class="sidebar__list__items">
        <li class="sidebar_items">
          <a href="./userHome.php"><i class='bx bxs-home'></i></span>Home</a>
        </li>

        <li class="sidebar_items">
          <a href="../user/dashboard.php"><i class='bx bxs-dashboard'></i></span>Dashboard</a>
        </li>

        <li class="sidebar_items">
          <a href="../user/profileSettings.php"><i class='bx bx-user-circle' ></i>My Profile</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bxs-heart'></i>Favourite</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-history'></i>Activity
            Feed</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-help-circle' ></i>Support & Help</a>
        </li>

        <li class="sidebar_items">
          <a href="./logOut.php"><i class='bx bx-log-out'></i>Logout</a>
        </li>
      </ul>
    </aside>
 

    <!-- ======= Book items Selection section starts ======= -->
    
    <section class="search__book__wrapper" id="search__book__wrapper">
        <div class="search__box__container">
            <div class="search__form" id="search__form">
                <form action="" method="POST">

                    <input type="text" id="bookName" name="bookName" placeholder="What do you want to read ?" class="book__search"></i>
                    <button onclick="searchByName()" class="search__book__btn"><i class='bx bx-search'></i></button>
                    
                    <div class="dropdown__category">
                        <button class="box__category">Category</button>
                        <div class="dropdown__options">
                            <a href="#" selected>BCA</a>
                            <a href="#">BIM</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
         <!-- BCA 1st Semester -->
    <section>
        <h2>BCA 1st Semester</h2>
        <section class="book__grid__container" id="bookGrid1">
          </section>
    </section>

    <!-- BCA 2nd Semester -->
    <section>
        <h2>BCA 2nd Semester</h2>
        <section class="book__grid__container" id="bookGrid2">
        </section>
    </section>

    <!-- BCA 3rd Semester -->
    <section>
            <h2>BCA 3rd Semester</h2>
            <section class="book__grid__container" id="bookGrid3">
            </section>
        </section>

    <!-- BCA 4th Semester -->
    <section>
        <h2>BCA 4th Semester</h2>
        <section class="book__grid__container" id="bookGrid4">
        </section>
    </section>

    <!-- BCA 5th Semester -->
    <section>
            <h2>BCA 5th Semester</h2>
            <section class="book__grid__container" id="bookGrid5">
            </section>
        </section>

    <!-- BCA 6th Semester -->
    <section>
        <h2>BCA 6th Semester</h2>
        <section class="book__grid__container" id="bookGrid6">
        </section>
    </section>

    <!-- BCA 7th Semester -->
    <section>
        <h2>BCA 7th Semester</h2>
        <section class="book__grid__container" id="bookGrid7">
        </section>
    </section>

    <!-- BCA 8th Semester -->
    <section>
            <h2>BCA 8th Semester</h2>
            <section class="book__grid__container" id="bookGrid8">
            </section>
        </section>


  </section>
</div>

    <!-- ======= Book items Selection section ends ======= -->
    <!-- ======================================================== -->

    <!-- ===JavaScript Link==== -->
    <script src="../../js/app.js"></script>
</body>

</html>