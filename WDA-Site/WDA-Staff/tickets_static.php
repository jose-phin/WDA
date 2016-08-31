<!DOCTYPE html>

<!-- Identifies user's location in website -->
<?php
    $currPage = "tickets";
?>

<html lang="en">

<head>

    <!-- Site metadata -->
    <title>Tickets &ndash; ITS Ticketing System | RMIT University </title>

    <!-- Global head items such as jQuery, Bootstrap, CSS, etc -->
    <?php include "../WDA-User/assets/head_items.php" ?>
    <link rel="stylesheet" href="../WDA-User/assets/css/style.css">
    <link rel="stylesheet" href="../WDA-User/assets/css/footer-style.css">
    <link rel="stylesheet" href="../WDA-User/assets/css/navbar-style.css">
    <link rel="stylesheet" href="../WDA-User/assets/css/tickets-style.css">

</head>
<!-- after i get the data -->
<!-- -->
<body>
    <div class="content">
        <div class="site-wide-container container">

            <!-- Navigation Bar -->
            <?php include_once "../WDA-User/navbar.php"; ?>

            <div class="hero main-hero">

                <h1 class=ticket-title>
                    Tickets
                </h1>
                <h1 class="h1-subtitle">
                    Did you try turning it off and on again?
                </h1>

            <!-- End of hero div -->
            </div>


            <!-- Instantiate Bootstrap's md-12 grid -->
            <div class="row">
                <div class="col-md-12">

            <!-- Tickets table begin -->
            <div class="ticket-header">
            <h5 class="ticket-header-text">
                Tickets
            </h5>
            </div>

            <!-- Ticket table begins -->
            <table class="table ticket-table" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>OS</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>

                <!-- Row 1 -->
                <tr data-toggle="collapse" data-target="#ticket1" class="accordion-toggle">
                    <td>1</td>
                    <td>
                        <span class="ticket-name">VirtualBox Error</span><br>
                        <span class="small">Username (user.name@mail.com)</span>
                    </td>
                    <td>
                        <span class="status status-unresolved">Unresolved</span>
                    </td>
                    <td>Software</td>
                    <td>Windows</td>
                    <td>18-08-16</td>
                </tr>
                <tr>
                    <td colspan="6" class="ticket-description">
                        <div class="accordion-body collapse" id="ticket1">
                            <p class="ticket-hidden">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </td>
                </tr>
                
                <!-- Row 2 -->
                <tr data-toggle="collapse" data-target="#ticket2" class="accordion-toggle">
                    <td>2</td>
                    <td>
                        <span class="ticket-name">Can't log into Blackboard</span><br>
                        <span class="small">Username (user.name@mail.com)</span>
                    </td>
                    <td>
                        <span class="status status-pending">Pending</span>
                    </td>
                    <td>Blackboard</td>
                    <td>macOS</td>
                    <td>17-08-16</td>
                </tr>
                <tr>
                    <td colspan="6" class="ticket-description">
                        <div id="ticket2" class="accordion-body collapse">
                            <p class="ticket-hidden">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr data-toggle="collapse" data-target="#ticket3" class="accordion-toggle">
                    <td>3</td>
                    <td>
                        <span class="ticket-name">Forgot RMIT student email password</span><br>
                        <span class="small">Username (user.name@mail.com)</span>
                    </td>
                    <td>
                        <span class="status status-resolved">Resolved</span>
                    </td>
                    <td>Email</td>
                    <td>Linux</td>
                    <td>03-08-16</td>
                </tr>
                <tr>
                    <td colspan="6" class="ticket-description">
                        <div id="ticket3" class="accordion-body collapse">
                            <p class="ticket-hidden">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr data-toggle="collapse" data-target="#ticket4" class="accordion-toggle">
                    <td>4</td>
                    <td>
                        <span class="ticket-name">Problems with Google Mail SMTP</span><br>
                        <span class="small">Username (user.name@mail.com)</span>
                    </td>
                    <td>
                        <span class="status status-in-progress">In Progress</span>
                    </td>
                    <td>Software</td>
                    <td>Windows</td>
                    <td>29-07-16</td>
                </tr>
                <tr>
                    <td colspan="6" class="ticket-description">
                        <div id="ticket4" class="accordion-body collapse">
                            <p class="ticket-hidden">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                                in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                                sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>



            </div>
        </div>


        <!-- End of site-wide container -->
        </div>
    </div>
</body>

<!-- Footer -->
<?php include "../WDA-User/footer.php"; ?>

</html>
