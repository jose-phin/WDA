
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
          		url: "/WDA/ticket/new",
          		contentType: 'application/json',
  				data: JSON.stringify({
  			// 		"user": {
  			// 			"firstName": $("input[name=firstname]").val(),
  			// 			"lastName": $("input[name=lastname]").val(),
  			// 			"email": $("input[name=email]").val()
  			// 		},
  			// 		"ticket": {
  			// 			"osType": $("#os").val(),
  			// 			"primaryIssue": $("#enquiry").val(),
  			// 			"additionalNotes": $("#description").val()
  			// 		}
  				}),
  				success:  function(formData) {
  					$("#report-issue").fadeOut(500).hide(function() {
  						$(".submitted").fadeIn(500).show(function() {
  							$(".result").text(formData);
  						});
  					});
  				}
  			});
  			return false;
  		});

});
