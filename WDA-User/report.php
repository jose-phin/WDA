<!-- FAQ -->
<!DOCTYPE html>

<!-- Identifies user's location in website -->
<?php
    $currPage = "report";
?>

<html lang="en">

<head>

    <!-- Site metadata -->
    <title>Report an Issue &ndash; ITS Ticketing System | RMIT University </title>

    <!-- Global head items such as jQuery, Bootstrap, CSS, etc -->
    <?php include "./assets/head_items.php" ?>
    <link rel="stylesheet" href="./assets/css/report-issue-style.css">
    <script src="./assets/js/report_issue_scripts.js"></script>

</head>

<body>
    <div class="content">
        <div class="site-wide-container container">

            <!-- Navigation Bar -->
            <?php include_once "navbar.php"; ?>

            <div class="hero main-hero">

                <h1>
                    Report an Issue
                </h1>
                <h1 class="h1-subtitle">
                    We got yo back.
                </h1>
                <p>
                    Please fill out the form below, and we will endeavour to answer your enquiry within 48 hours.
                </p>

            <!-- End of hero div -->
            </div>

            <!-- Instantiate Bootstrap's col-sm-4 grid -->
            <div class="row">

                    <!-- Form begins -->
                    <form id="report-issue" method="post" action="" autocomplete="off" novalidate="novalidate">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="firstname">First Name</label>*
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>*
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="email">Email Address</label>*
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="enquiry">Type of Enquiry</label>*
                            <select class="form-control" id="enquiry">
                            <option disabled selected value> -- Select an option -- </option>
                            <option>General IT Enquiry</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                            <option>Option 4</option>
                            <option>Other (Please specify)</option>
                            </select>
                        </div>

                        <!-- Eventually, this will only show when "Other" is clicked -->
                        <div class="form-group" style="display:none">
                            <label for="other-enquiry">Other (Please specify)</label>
                            <input type="other-enquiry" class="form-control" id="other-equiry" area-describedby="other-enquiry-help" placeholder="">
                            <small id="other-enquiery-help" class="form-text text-muted">What?!</small>
                        </div>

                        <div class="form-group">
                            <label for="os">Operating System</label>
                            <select class="form-control" id="os">
                            <option disabled selected value> -- Select an option -- </option>
                            <option>Windows</option>
                            <option>Mac OS</option>
                            <option>Linux</option>
                            <option>Ubuntu</option>
                            <option>Other (Please specify)</option>
                            </select>
                        </div>

                        <div class="form-group text-description">
                            <legend>Issue Description*</legend>
                            <p>
                                Please provide more details of your issue in the text box below.
                                Dtails such as computer names, website paths, account numbers,
                                and error numbers will help us to resolve your issue more efficiently.
                            </p>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Provide more details here..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                        </div><!-- End col-sm-8 -->

                    </form>
                    <!-- End form -->

                    </div>
                </div>
            </div>


        <!-- End of site-wide container -->
        </div>
    </div>
</body>

<!-- Footer -->
<?php include "footer.php"; ?>

</html>
