
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

    // Process form
    $(document).submit("#user-login", function() {

  			/* Serialised data */
  			var data = $("#user-login").serialize();

  			$.ajax({
  				type: "POST",
          		url: "/WDA/ticket/view",
          		contentType: 'application/json',
  				data: JSON.stringify({
						"ticketId": $("#ticketId-input").val()
  				}),
  				success:  function(formData) {
  					$("#user-login").fadeOut(500).hide(function() {
  						$(".TEST").fadeIn(500).show(function() {
  							$(".result").text(formData);
  						});
  					});
  				}
  			});
  			return false;
  		});

});
