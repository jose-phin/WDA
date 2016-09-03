$(document).ready(function(){

    /* Update the status button in the table */
    $(".dropdown-menu li a").click(function(){

        var selectedStatus = $(this).text();
        var STATICSTATUS = "status user-ticket-status ";
        var BULLETSTATUS = "<i class='fa fa-circle fa-1 fa-statusTag' aria-hidden='true'></i>"

        function replaceClass(selectedStatus, newStatus) {

            $(".user-ticket-status").removeClass().addClass(STATICSTATUS + newStatus);
            $(".user-ticket-status").find(".status-text").text(selectedStatus);
            sendStatus(selectedStatus);
        }

        if (selectedStatus === "In progress") {
            replaceClass(selectedStatus, "status status-in-progress white");
            $(".user-ticket-status").html(BULLETSTATUS+"in progress");
        }

        if (selectedStatus === "Pending") {
            replaceClass(selectedStatus, "status status-pending");
            $(".user-ticket-status").html(BULLETSTATUS+"pending");
        }

        if (selectedStatus === "Resolved") {
            replaceClass(selectedStatus, "status status-resolved");
            $(".user-ticket-status").html(BULLETSTATUS+"resolved");
        }

        if (selectedStatus === "Unresolved") {
            replaceClass(selectedStatus, "status status-unresolved");
            $(".user-ticket-status").html(BULLETSTATUS+"unresolved");
        }

    });

});


/* Send status to database */
function sendStatus(selectedStatus) {

    $.ajax({
        type: "POST",
        url: "/WDA/ticket/update",
        contentType: "application/json",
        data: JSON.stringify({
            "ticket": {
                    "ticketId": ticket.ticket.ticket_id.toString(),
                    "status": selectedStatus.toLowerCase()
                }
        }),
        success: function(formData) {
            response = jQuery.parseJSON(formData);

            console.log(response);
            if (response.success === false) {
                console.log("Ticket status failed to update!");
            }

            if (response.success === true) {
                console.log("Ticket status updated!");
            }
        }
    });

    return false;
}
