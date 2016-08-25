<!-- Main landing page -->
<!DOCTYPE html>

<!-- Identifies user's location in website -->
<?php
    $currPage = "ticket";
?>

<html lang="en">

<head>

    <!-- Site metadata -->
    <title>Your Ticket - ITS Ticketing System | RMIT University </title>

    <!-- Global head items such as jQuery, Bootstrap, CSS, etc -->
    <?php include "./assets/head_items.php" ?>
    <link rel="stylesheet" href="./assets/css/individual-ticket-style.css">
    <script src="./assets/js/follow-up-script.js"></script>

</head>

<body>
    <div class="home-body content">

        <div class="site-wide-container container">

            <!-- Navigation Bar -->
            <?php include "navbar.php"; ?>

            <div class="hero main-hero">

                <h2 class="user-ticket-ticketTitle">
                    {{Ticket Title}}
                </h2>

                <div class="row">
                    <div class="col-sm-2">
                        <h4>
                            {{Ticket ID: #12345}}
                        </h4>
                    </div>
                    <!-- Ticket status -->
                    <div class="col-sm-2">
                        <span class="status status-unresolved">Unresolved</span>
                    </div>
                </div>

                <!-- Instantiate Bootstrap's md-10 grid -->
                <div class="row">
                    <div class="col-md-10">
                        <!-- User ticket contents -->
                        <?php include './assets/content/individual-ticket.php' ?>

                        <!-- Return home button -->
                        <div class="row btn-margin-fix">
                            <div class="col-sm-12 col-md-2 btn-col ">
                                <a href="./home.php">
                                    <button class="btn btn-secondary follow-up-home-button">Return Home</button>
                                </a>
                            </div>
                        </div>
                    <!-- End of col-md-10 -->
                    </div>
                <!-- End of content row -->
                </div>

            <!-- End of hero div -->
            </div>

        <!-- End of site-wide container -->
        </div>



    </div>
</body>

<!-- Footer -->
<?php include_once "footer.php"; ?>

</html>
