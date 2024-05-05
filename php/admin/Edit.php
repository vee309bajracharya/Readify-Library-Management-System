<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

if (isset($_POST['submit'])) {
    $books_id = $_POST["books_id"];
    $books_name = $_POST["books_name"];
    $authors = $_POST['authors'];
    $edition = $_POST['edition'];
    $quantity = $_POST['quantity'];
    $department = $_POST['department'];
    $book_cover_url = $_POST['book_cover_url'];

    // Check if the quantity is zero
    $status = ($quantity == 0) ? "Unavailable" : "Available";

    // Check if a new book cover URL is provided
    if (!empty($book_cover_url)) {
        // Fetch book cover from URL and save it locally
        $image_data = file_get_contents($book_cover_url);
        $book_cover_name = basename($book_cover_url);
        $book_cover_path = "./covers/" . $book_cover_name;
        file_put_contents($book_cover_path, $image_data);

        // Update book cover in the database
        $sql_cover = "UPDATE library_books SET book_cover = ? WHERE books_id = ?";
        $stmt_cover = $conn->prepare($sql_cover);
        $stmt_cover->bind_param("si", $book_cover_name, $books_id);

        if (!$stmt_cover->execute()) {
            $_SESSION['msg'] = "Error updating book image";
            $_SESSION['msg_code'] = "error";
        }

        $stmt_cover->close();
    }

    // Update other book information in the database
    $sql = "UPDATE library_books SET books_name = ?, authors = ?, edition = ?, status = ?, quantity = ?, department = ? WHERE books_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $books_name, $authors, $edition, $status, $quantity, $department, $books_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Book Updated Successfully!!";
        $_SESSION['msg_code'] = "success";
        header("Location: Managebooks.php");
        exit(); // Ensure that no other code executes after the redirect
    } else {
        $_SESSION['msg'] = "Error updating book info";
        $_SESSION['msg_code'] = "error";
    }


    $stmt->close();
}

// Fetch book information for editing
if (isset($_GET['id'])) {
    $books_id = $_GET['id'];

    $sql = "SELECT * FROM library_books WHERE books_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $books_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['msg'] = "Book not found";
        $_SESSION['msg_code'] = "error";
    } else {
        $row = $result->fetch_assoc();
        $books_name = $row['books_name'];
        $authors = $row['authors'];
        $edition = $row['edition'];
        $quantity = $row['quantity'];
        $department = $row['department'];
        $book_cover = $row['book_cover'];
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>

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

            <section class="container-form">
                <div class="form__box custom__box book-box">

                    <div class="signup__intro">
                        <h2 style="font-weight: bold; color: #5955E7;"><i class='bx bxs-edit'></i> Edit Book</h2>

                    </div>

                    <form class="bookForm" action="./Edit.php" method="POST">


                        <input type="hidden" name="books_id" value="<?php echo $books_id; ?>">

                        <div class="field input">
                            <label for="bookName">Book Name</label>
                            <input type="text" name="books_name" id="books_name" value="<?php echo $books_name; ?>"
                                required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookAuthor">Book Author</label>
                            <input type="text" name="authors" id="authors" value="<?php echo $authors; ?>"
                                required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookEdition">Book Edition</label>
                            <input type="text" name="edition" id="edition" value="<?php echo $edition; ?>"
                                required=""><br>
                        </div>

                        <!-- Remove Book Status field -->

                        <div class="field input">
                            <label for="bookQty">Book Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>"
                                required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookDept">Book Department</label>
                            <input type="text" name="department" id="department" value="<?php echo $department; ?>"
                                required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookCover">Book Cover</label>
                            <input type="text" name="book_cover_url" id="book_cover_url" value="" required="">
                        </div>


                        <div class="btn-container">
                            <button class="btn-search" type="submit" name="submit" value="submit">Save</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>


    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
    include ('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>