<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <!-- Title icon -->
  <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

  <!-- CSS Links -->
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="stylesheet" href="../../css/responsive.css" />

  <!-- ==== Boxicons link ==== -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />

  <!-- Material Icon Link -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

  <!--  Bootstrap Icons Link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
          <a href="../user/home.html"><i class='bx bxs-home'></i></span>Home</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bxs-dashboard'></i></span>Dashboard</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-user-circle'></i>My Profile</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bxs-heart'></i>Favourite</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-history'></i>Activity
            Feed</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-help-circle'></i>Support & Help</a>
        </li>

        <li class="sidebar_items">
          <a href=""><i class='bx bx-log-out'></i>Logout</a>
        </li>
      </ul>
    </aside>




    <!-- === Dashboard main content === -->
    <main class="dashboard__main__content">
      <div class="dashboard__title">
        <h2 class="text-left">Welcome to Dashboard</h2>
        <small>User/Dashboard</small>
      </div>
      <div class="cards__wrapper">
        <div class="cards__grid">
          <!-- main Cards -->
          <div class="card">
            <div class="card-flex">
              <div class="card__info">
                <h3>
                  10 <br />
                  <span>Books Borrowed</span>
                </h3>
                <a href="" class="show-details">View Details &rarr;</a>
              </div>
              <div class="card-info-icon">
                <img src="../../svg/borrow.svg" alt="borrow" />
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-flex">
              <div class="card__info">
                <h3>
                  10 <br />
                  <span>Books Returned</span>
                </h3>
                <a href="" class="show-details">View Details &rarr;</a>
              </div>
              <div class="card-info-icon">
                <img src="../../svg/returned.svg" alt="borrow" />
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-flex">
              <div class="card__info">
                <h3>
                  10 <br />
                  <span>Books Reserved</span>
                </h3>
                <a href="" class="show-details">View Details &rarr;</a>
              </div>
              <div class="card-info-icon">
                <img src="../../svg/reserved.svg" alt="borrow" />
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-flex">
              <div class="card__info">
                <h3>
                  10 <br />
                  <span>Books Lost</span>
                </h3>
                <a href="" class="show-details">View Details &rarr;</a>
              </div>
              <div class="card-info-icon">
                <img src="../../svg/lost.svg" alt="borrow" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- JS link -->
  <script src="../../js/app.js"></script>
</body>

</html>