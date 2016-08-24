
$(document).ready(function(){

    // Toggle slide down hero div for pseudo-login
    $(".follow-up-home-button").click(function(){
        $(".follow-up-hero-div").slideToggle("fast", "swing");
        $(this).toggleClass("clicked");
        $(this).toggleClass("active");
    });

    // Validation
    $("#user-login").validate({
        rules: {
            ticketID: {
                required: true
            },
        },
        messages: {
            ticketID: {
                required: "Please enter your Ticket ID."
            }
        }
    });


});
