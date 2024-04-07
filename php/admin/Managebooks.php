<?php 
    include "./adminNavbar.php"; //navbar along with sidenav
    require_once "../config.php"; //database connection file

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

</head>
<body>
    
<!-- include Sidebar -->
    <?php 
        include "./adminSidebar.php";
    ?>

    <div class="list_container">
    <div id="main">
      



      <!--  ===== Seachbar for books ===== -->
      <div class="searchBar__wrapper">
          <h2> Manage Books </h2>
              <form action="" class="navbar-form-c" method="POST" name="form-1">
                  <div class="search searchBar_field">
                      <input class="form-control-search" type="text" name="search" placeholder="Type Book Name" style="width:100%" ; required>
                      <button type="submit" name="submit" class="btn-search">Search</button>
                  </div>
              </form>
      </div>
  
  
      <?php
  // ========== search book names =================
  if (isset($_POST['submit'])) {
      $search = mysqli_real_escape_string($conn, $_POST['search']);
      $searchBarQuery = mysqli_query($conn, "SELECT * FROM library_books WHERE books_name LIKE '%$search%'");
  
      if (mysqli_num_rows($searchBarQuery) == 0) {
        echo "<section>";
        echo "<div class='error_container'>";
        echo "<img src='../../images/book_not_found.png' alt='Book Not Found' id='notFound'>";
        echo "</div>";
        echo "</section>";
    } else {
          echo "<div>";
          echo "<table class='table table-bordered table-hover'>";
          echo "<tr>";
          //Table header
          echo "<th>"; echo "Books ID"; echo "</th>";
          echo "<th>"; echo "Books Name"; echo "</th>";
          echo "<th>"; echo "Book Cover"; echo "</th>";
          echo "<th>"; echo "Edition"; echo "</th>";
          echo "<th>"; echo "Authors"; echo "</th>";
          echo "<th>"; echo "Status"; echo "</th>";
          echo "<th>"; echo "Quantity"; echo "</th>";
          echo "<th>"; echo "Department"; echo "</th>";
          echo "<th>"; echo "Action"; echo "</th>";
          echo "</tr>";
  
          while ($row = mysqli_fetch_assoc($searchBarQuery)) {
              echo "<tr>";
              //fetch data from library_books table
              echo "<td>" . $row['books_id'] . "</td>";
              echo "<td>" . $row['books_name'] . "</td>";
              echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='120' style='object-fit: cover; border-radius: 5px;'></td>";
              echo "<td>" . $row['edition'] . "</td>";
              echo "<td>" . $row['authors'] . "</td>";
              echo "<td>" . $row['status'] . "</td>";
              echo "<td>" . $row['quantity'] . "</td>";
              echo "<td>" . $row['department'] . "</td>";
              echo "<td class='action-div'><button type='button' class='btn btn-warning' onclick=\"window.location.href='Edit.php?id={$row['books_id']}'\"><i class='bi bi-pencil-square'></i></button> <a href='Delete.php?id={$row['books_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this book?\")'><i class='bi bi-trash3-fill'></i></a>";
              echo "</tr>";
          }
          echo "</table>";
          echo "</div>";
          }
          }else {
              $result = mysqli_query($conn, "SELECT * FROM `library_books` ORDER BY `library_books`.`books_id` ASC;");
              echo "<div>";
              echo "<table class='table table-bordered table-hover'>";
              echo "<tr>";
              //Table header
              echo "<th>"; echo "Books ID"; echo "</th>";
              echo "<th>"; echo "Books Name"; echo "</th>";
              echo "<th>"; echo "Book Cover"; echo "</th>";
              echo "<th>"; echo "Edition"; echo "</th>";
              echo "<th>"; echo "Authors"; echo "</th>";
              echo "<th>"; echo "Status"; echo "</th>";
              echo "<th>"; echo "Quantity"; echo "</th>";
              echo "<th>"; echo "Department"; echo "</th>";
              echo "<th>"; echo "Action"; echo "</th>";
              echo "</tr>";
  
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  //fetch data from library_books table
                  echo "<td>" . $row['books_id'] . "</td>";
                  echo "<td>" . $row['books_name'] . "</td>";
                echo "<td style='text-align:center;'><img src='../admin/covers/" . $row['book_cover'] . "' alt='Book Cover' width='120' style='object-fit: cover; border-radius: 5px;'></td>";
                  echo "<td>" . $row['edition'] . "</td>";
                  echo "<td>" . $row['authors'] . "</td>";
                  echo "<td>" . $row['status'] . "</td>";
                  echo "<td>" . $row['quantity'] . "</td>";
                  echo "<td>" . $row['department'] . "</td>";
                  echo "<td class='action-div'><button type='button' class='btn btn-warning' onclick=\"window.location.href='Edit.php?id={$row['books_id']}'\"><i class='bi bi-pencil-square'></i></button> <a href='Delete.php?id={$row['books_id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this book?\")'><i class='bi bi-trash3-fill'></i></a>";
                  echo "</tr>";
              }
              echo "</table>";
              echo "</div>";
          }
  ?>
    </div>
      

    </div>
</body>
</html>