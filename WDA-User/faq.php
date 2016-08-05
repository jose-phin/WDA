<!-- FAQ -->
<!DOCTYPE html>

<!-- Identifies user's location in website -->
<?php
    $currPage = "faq";
?>

<html lang="en">

<head>

    <!-- Site metadata -->
    <title>FAQ - ITS Ticketing System | RMIT University </title>

    <!-- Global head items such as jQuery, Bootstrap, CSS, etc -->
    <?php include "./assets/head_items.php" ?>
    <link rel="stylesheet" href="./assets/css/faq-style.css">

</head>

<body>

    <div class="site-wide-container container">

        <!-- Navigation Bar -->
        <?php include_once "navbar.php"; ?>

        <div class="hero main-hero">

            <h1 class=faq-title>
                Frequently Asked Questions
            </h1>
            <h1 class="h1-subtitle">
                All your basics covered.
            </h1>

        <!-- End of hero div -->
        </div>


        <!-- Instantiate Bootstrap's md-10 grid -->
        <div class="row">
            <div class="col-md-10">

                <!-- FAQ contents -->
                <?php include "./assets/content/faq-student-content.php" ?>
                <?php include "./assets/content/faq-staff-content.php" ?>
                <!-- Submit a ticket hero banner -->

                <!-- ARGHHHH 💩 damn you CSS -->
                <div class="faq-ticket-hero">
                    <div class="col-md-4">
                        Didn't find your questions here?
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary">Submit a Ticket</button>
                    </div>

                </div>
            </div>
        </div>


    <!-- End of site-wide container -->
    </div>
</body>

<!-- Footer -->
<?php include_once "footer.php"; ?>

</html>
