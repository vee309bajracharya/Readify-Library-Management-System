<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete book</title>
</head>

<body>
<?php
session_start(); // Start the session

if (isset($_GET["id"])) {
    $books_id = $_GET["id"];
    require_once "../config.php";

    $sql = "DELETE FROM library_books WHERE books_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $books_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Book Deleted Successfully!!";
        $_SESSION['msg_code'] = "success";
    } else {
        $_SESSION['msg'] = "Error deleting book";
        $_SESSION['msg_code'] = "error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ./Managebooks.php"); // Redirect to viewBook.php after deletion
    exit;
} else {
    $_SESSION['msg'] = "No book ID provided for deletion";
    $_SESSION['msg_code'] = "error";
    header("Location: ./Managebooks.php"); // Redirect to viewBook.php if no ID is provided
    exit;
}
?>


    <!-- jquery, popper, bootstrapJS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- === sweetAlert link === -->
    <script src="../sweetAlert/sweetalert.js"></script>

    <?php
        include('../sweetAlert/sweetalert_actions.php');
    ?>
</body>

</html>