/* submit-form-script.js */

$(document).ready(function() {

	$(".submitted").hide();

	/* Process the form */
	$(document).submit("#report-issue", function() {

			/* Serialised data */
			var data = $("#report-issue").serialize();

			$.ajax({
				type: "POST",
		        url: "../../API/endpoints/ticket.php?endpoint=new",
		        contentType: 'application/json',
				data: JSON.stringify({
					"user": {
						"firstName": $("input[name=firstname]").val(),
						"lastName": $("input[name=lastname]").val(),
						"email": $("input[name=email]").val()
					},
					"ticket": {
						"osType": $("input[name=os]").val(),
						"primaryIssue": $("input[name=enquiry]").val(),
						"additionalNotes": $("input[name=description]").val()
					}
				}),
				success:  function(data) {
					$("#report-issue").fadeOut(500).hide(function() {
						$(".submitted").fadeIn(500).show(function() {

							// Display response data
							$(".result").text(data);


						});
					});
				}
			});
			return false;
		});
});
