<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "./adminNavbar.php"; // Include navbar along with sidenav
require_once "../config.php"; // Include database connection file

$errorMessage = "";

if (isset($_POST['submit'])) {
    $books_id = $_POST["books_id"];
    $books_name = $_POST["books_name"];
    $authors = $_POST['authors'];
    $edition = $_POST['edition'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $department = $_POST['department'];

    // Update the book information in the database
    $sql = "UPDATE library_books SET books_name = ?, authors = ?, edition = ?, status = ?, quantity = ?, department = ? WHERE books_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $books_name, $authors, $edition, $status, $quantity, $department, $books_id);

    if ($stmt->execute()) {
        $successMessage = "Book Updated Successfully :)";
        header("location: viewBook.php");
        exit;
    } else {
        $errorMessage = "Error Updating Book: " . $stmt->error;
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
        $errorMessage = "Book not found";
    } else {
        $row = $result->fetch_assoc();
        $books_name = $row['books_name'];
        $authors = $row['authors'];
        $edition = $row['edition'];
        $status = $row['status'];
        $quantity = $row['quantity'];
        $department = $row['department'];
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
                            <input type="text" name="books_name" id="books_name" value="<?php echo $books_name; ?>" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookAuthor">Book Author</label>
                            <input type="text" name="authors" id="authors" value="<?php echo $authors; ?>" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookEdition">Book Edition</label>
                            <input type="text" name="edition" id="edition" value="<?php echo $edition; ?>" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookStatus">Book Status</label>
                            <input type="text" name="status" id="status" value="<?php echo $status; ?>" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookQty">Book Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" required=""><br>
                        </div>

                        <div class="field input">
                            <label for="bookDept">Book Department</label>
                            <input type="text" name="department" id="department" value="<?php echo $department; ?>" required=""><br>
                        </div>


                        <div class="btn-container">
                            <button class="btn-search" type="submit" name="submit" value="submit">Save</button>
                        </div>
                    </form>





                </div>
            </section>





        </div>
    </div>
</body>

</html>