<?php
require_once "../config.php";
include "./userNavbar.php";

if (!isset($_SESSION['user'])) {
    header("Location: ./log-in.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Readify</title>

    <!-- Title icon -->
    <link rel="icon" href="../../icons/title_icon.png" type="image/x-icon" />

    <!-- ==== CSS Links ==== -->
    <link rel="stylesheet" href="../../css/custom_bootstrap.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <!-- include Dashboard -->
    <?php
    include "./userDashboard.php";
    ?>

    <div class="list_container">
        <div id="main">
            <h3>Support and Help</h3>

            <div class="container my-5">

                <!-- Book Request Section -->
                <h4 class="fw-bold">Book Request</h4>
                <div class="accordion" id="bookRequestAccordion">
                    <div class="card">
                        <div class="card-header" id="bookRequestHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookRequestCollapse" aria-expanded="true"
                                    aria-controls="bookRequestCollapse">
                                    <b>How many books can I request at a time?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookRequestCollapse" class="collapse show" aria-labelledby="bookRequestHeading"
                            data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                You can request up to 5 books at a time.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookApprovalHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookApprovalCollapse" aria-expanded="true"
                                    aria-controls="bookApprovalCollapse">
                                    <b> How long does it take for a requested book to be approved and delivered?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookApprovalCollapse" class="collapse" aria-labelledby="bookApprovalHeading"
                            data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                After requesting a book, it will be approved by the admin. Once approved, delivery is
                                guaranteed within 24 hours.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookCancellationHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookCancellationCollapse" aria-expanded="true"
                                    aria-controls="bookCancellationCollapse">
                                    <b> Can I cancel a book after it has been approved?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookCancellationCollapse" class="collapse" aria-labelledby="bookCancellationHeading"
                            data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                No, once a book has been approved, it cannot be cancelled.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookReturnRequirementHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookReturnRequirementCollapse" aria-expanded="true"
                                    aria-controls="bookReturnRequirementCollapse">
                                    <b> Do I need to return books and pay fine to the library physically?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookReturnRequirementCollapse" class="collapse"
                            aria-labelledby="bookReturnRequirementHeading" data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                Yes, books must be returned and pay fine by visiting our library.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookReturnRequirementHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookReturnRequirementCollapse" aria-expanded="true"
                                    aria-controls="bookReturnRequirementCollapse">
                                    <b> Is there a time limit for borrowing books?</b>                               </button>
                            </h5>
                        </div>

                        <div id="bookReturnRequirementCollapse" class="collapse"
                            aria-labelledby="bookReturnRequirementHeading" data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                Yes, the time duration for borrowing a book is 6 months.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookRequestDetailsHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookRequestDetailsCollapse" aria-expanded="true"
                                    aria-controls="bookRequestDetailsCollapse">
                                    <b> What information will be shown in my system after requesting a book?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookRequestDetailsCollapse" class="collapse"
                            aria-labelledby="bookRequestDetailsHeading" data-parent="#bookRequestAccordion">
                            <div class="card-body">
                                After requesting a book, your system will display the requested date, book issued date,
                                and return date.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Book Return, Expire and Lost Section -->
                <h4 class="fw-bold mt-5">Book Return, Expire and Lost</h4>
                <div class="accordion" id="bookReturnAccordion">
                    <div class="card">
                        <div class="card-header" id="bookReturnFineHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookReturnFineCollapse" aria-expanded="true"
                                    aria-controls="bookReturnFineCollapse">
                                    <b> What happens if I return a book after the due date?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookReturnFineCollapse" class="collapse show" aria-labelledby="bookReturnFineHeading"
                            data-parent="#bookReturnAccordion">
                            <div class="card-body">
                                If you return a book after the due date, a fine of Rs. 40 will be charged for each day
                                until the fine is paid.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookExpirationHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookExpirationCollapse" aria-expanded="true"
                                    aria-controls="bookExpirationCollapse">
                                    <b> What happens if a book is not returned within the specified time frame?</b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookExpirationCollapse" class="collapse" aria-labelledby="bookExpirationHeading"
                            data-parent="#bookReturnAccordion">
                            <div class="card-body">
                                If a book is not returned within the specified time frame, the status will automatically
                                show as 'Expired'. You will be fined accordingly, and the book will be considered lost.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookLostPenaltyHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookLostPenaltyCollapse" aria-expanded="true"
                                    aria-controls="bookLostPenaltyCollapse">
                                    <b> What is the penalty for a lost book?</b> 
                                </button>
                            </h5>
                        </div>

                        <div id="bookLostPenaltyCollapse" class="collapse" aria-labelledby="bookLostPenaltyHeading"
                            data-parent="#bookReturnAccordion">
                            <div class="card-body">
                                If a book is not returned within 1 month, it will be declared lost. In such a case, a
                                fine penalty of Rs. 5000 is compulsory.
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="bookReturnWindowHeading">
                            <h5 class="mb-0">
                                <button class="btn" type="button" data-toggle="collapse"
                                    data-target="#bookReturnWindowCollapse" aria-expanded="true"
                                    aria-controls="bookReturnWindowCollapse">
                                    <b> Is there a grace period for returning books? </b>
                                </button>
                            </h5>
                        </div>

                        <div id="bookReturnWindowCollapse" class="collapse" aria-labelledby="bookReturnWindowHeading"
                            data-parent="#bookReturnAccordion">
                            <div class="card-body">
                                Yes, our library system provides a 1-month grace period for users to return borrowed
                                books.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>