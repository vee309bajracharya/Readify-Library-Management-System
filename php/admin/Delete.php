<?php
if(isset($_GET["id"])){
    $books_id = $_GET["id"];
    require_once "../config.php";

    $sql = "DELETE FROM library_books WHERE books_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $books_id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("location:adminDashboard.php");
    exit;
}
?>
