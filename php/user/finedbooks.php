<?php
                if (isset($_SESSION['user'])) {
                    $fine = 0;
                    include "./fineinfo.php";

                    $loggedInUser = $_SESSION['user'];
                    // Assuming $_SESSION['user'] contains the user ID of the logged-in user
                    $userId = $_SESSION['user'];

                    $query = "SELECT SUM(fine) AS total_fine FROM fine WHERE username = '$loggedInUser'";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $fine = $row['total_fine'];
                        if ($fine > 0) {

                            echo "Total fine: रु॰ " . $fine ; //+ $fineinfo
                        } else {
                            echo "No fine";
                        }
                    } else {
                        echo "Error retrieving fine information";
                    }
                }
                ?>