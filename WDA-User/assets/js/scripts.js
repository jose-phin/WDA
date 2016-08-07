/*Form validation*/

$(document).ready(function () {

    $("#report-issue").validate({
        rules: {
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            enquiry: {
                required: true
            },
            description: {
                required: true
            }
        },
        messages: {
            firstname: {
                required: "Please enter your first name."
            },
            lastname: {
                required: "Please enter your last name."
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address."
            },
            enquiry: {
                required: "Please choose an enquiry type from the drop down menu."
            },
            description: {
                required: "Please provide a description of your issue."
            }
        }
    })

    /*AJAX
    .on("submit", "#report-issue", function() {
        var name = $("#name").val();
        var email = $("#email").val();
        var data = name + ", " + email;
        var data = $(this).serialize();

        $.ajax({
            url: "submit.php",
            type: "POST",
            data: $form.serialize(),
            success: function(data) {
                $("#report-issue").fadeOut(500).hide(function() {
                    $(".result").fadeIn(500).show(function() {
                        $(".result").html(data);
                    });
                });
            }
        });
        return false;
    }); */

});