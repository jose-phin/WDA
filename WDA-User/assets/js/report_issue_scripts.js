/*Form validation*/
$(document).ready(function () {
    $("#report-issue").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter your name."
            },
            email: {
                required: "Please enter your email.",
                email: "Please enter a valid email address."
            },
            description: {
                required: "Please provide a description of your issue."
            }
        }
    });
});
