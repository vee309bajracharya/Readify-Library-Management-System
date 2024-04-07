<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./adminNavbar.php"; //navbar along with sidenav
require_once "../config.php"; //database connection file

if (isset($_POST['submit'])) {
    if (isset($_SESSION['admin'])) {

        $book_cover_url = $_POST['book_cover_url'];

        // Fetch the image from the provided URL and save it locally
        $image_data = file_get_contents($book_cover_url);
        $book_cover_name = basename($book_cover_url);
        $book_cover_path = "./covers/" . $book_cover_name;
        file_put_contents($book_cover_path, $image_data);

        $books_name = $_POST['books_name'];
        $authors = $_POST['authors'];
        $edition = $_POST['edition'];
        $status = $_POST['status'];
        $quantity = $_POST['quantity'];
        $department = $_POST['department'];
        $book_cover = $book_cover_name;


        $stmt = $conn->prepare("INSERT INTO library_books (books_name, authors, edition, status, quantity, department, book_cover) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $books_name, $authors, $edition, $status, $quantity, $department, $book_cover);


        if ($stmt->execute()) {
            echo "<script>alert('Successfully Books Added')</script>";
            echo "<script>window.location.href = './viewBook.php';</script>";
            exit; // Stop execution after redirection
        } else {
            echo "<script>alert('Error Adding Book: " . $stmt->error . "')</script>";
        }

        $stmt->close();
    }
}
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

    <!-- ====== Sidebar ======== -->
    <div class="list_container">
        <div id="main">

            <section class="container-form">
                <div class="form__box custom__box book-box">

                    <div class="signup__intro">
                        <h2 style="font-weight: bold; color: #5955E7;"><i class='bx bxs-book-add'></i> Add New Book</h2>

                    </div>


                    <form action="./Issued.php" method="POST" class="bookForm" enctype="multipart/form-data">

                        <div class="field input">
                            <label for="bookName">Book Name</label>
                            <input type="text" name="books_name" id="books_name" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookAuthor">Book Author</label>
                            <input type="text" name="authors" id="authors" required="">
                        </div>

                        <div class="field input">
                            <label for="bookEdition">Book Edition</label>
                            <input type="text" name="edition" id="edition" required="">
                        </div>

                        <div class="field input">
                            <label for="bookStatus">Book Status</label>
                            <input type="text" name="status" id="status" placeholder="Available" required="">
                        </div>

                        <div class="field input">
                            <label for="bookQty">Book Quantity</label>
                            <input type="number" name="quantity" id="quantity" required="">
                        </div>

                        <div class="field input">
                            <label for="bookDept">Book Department</label>
                            <input type="text" name="department" id="department" required="">
                        </div>

                        <div class="field input">
                            <label for="bookCover">Book Cover</label>
                            <input type="text" name="book_cover_url" id="book_cover_url" placeholder="Book Img URL">
                        </div>

                        <div class="btn-container">
                            <button class="btn-search" type="submit" name="submit" value="submit">Confirm</button>
                        </div>

                    </form>

                </div>
            </section>

        </div>
    </div>

</body>

</html>