<!-- Main landing page -->
<!DOCTYPE html>

<!-- Identifies user's location in website -->
<?php
    $currPage = "home";
?>

<html lang="en">

<head>

    <!-- Site metadata -->
    <title>ITS Ticketing System | RMIT University </title>

    <!-- Global head items such as jQuery, Bootstrap, CSS, etc -->
    <?php include "./assets/head_items.php" ?>

</head>

<body>

    <div class="site-wide-container container">

        <!-- Navigation Bar -->
        <?php include_once "navbar.php"; ?>

        <div class="hero main-hero">

            <h1>
                ITS Ticketing System
            </h1>
            <h1 class="h1-subtitle">
                Tech questions answered, quick.
            </h1>

            <p class="hero-description">
                Information Technology Services (ITS) provides RMIT University
                with information and communication technology in support of
                RMIT's research, learning teaching and administrative activities.
            </br></br>
                ITS Ticketing System allows RMIT students and staff members to
                report any IT-related issues and get help and support from our team.
            </p>

            <button class="btn btn-primary">Report an Issue</button>

        <!-- End of hero div -->
        </div>

    <!-- End of site-wide container -->
    </div>
</body>

<!-- Footer -->
<?php include_once "footer.php"; ?>

</html>
