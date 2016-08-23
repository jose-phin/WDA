/* submit-form-script.js */

$(document).ready(function() {

	$(".submitted").hide();

	/* Process the form */
	$(document).submit("#report-issue", function() {

			/* Serialised data */
			var data = $("#report-issue").serialize();

			$.ajax({
				type: "POST",
		        url: "../../API/endpoints/ticket.php?endpoint=/new",
		        contentType: 'application/json',
				data: JSON.stringify(
					{
						"user": {
							"firstName": $("input[name=firstname]").val(),
							"lastName": $("input[name=lastname]").val(),
							"email": $("input[name=email]").val()
						},
						"ticket": {
							"osType": $("#os").val(),
							"primaryIssue": $("#enquiry").val(),
							"additionalNotes": $("#description").val()
						}
					}
				),
				success:  function(results) {
					$("#report-issue").fadeOut(100).hide(function() {
						$(".submitted").fadeIn(100).show(function() {

							// Display response data
							$(".result").text(results);
							return results;

						});
					});
				}
			});
			return false;
		});
});
