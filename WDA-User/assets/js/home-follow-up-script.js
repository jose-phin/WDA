
// Toggle slide down hero div for pseudo-login

$(document).ready(function(){

    $(".follow-up-home-button").click(function(){
        $(".follow-up-hero-div").slideToggle("fast", "swing");
        $(this).toggleClass("clicked");
        $(this).toggleClass("active");
    });

});
