/* submit-form-script.js */

$(document).ready(function() {

	$(".submitted").hide();

	/* Process the form */
	$(document).submit("#report-issue", function() {

			/* Serialised data */
			var data = $("#report-issue").serialize();

			$.ajax({
				type: "POST",
        url: "/WDA/ticket/new",
        contentType: 'application/json',
				data: JSON.stringify({
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
				}),
				success:  function(formData) {
					$("#report-issue").fadeOut(500).hide(function() {
						$(".submitted").fadeIn(500).show(function() {
							$(".result").text(data);
						});
					});
				}
			});
			return false;
		});
});
