$(document).ready(function(){

    /* Confirm close */
    $("#confirm-CloseTicket-btn").click(function(){

        $.ajax({
            type: "POST",
            url: "/WDA/ticket/close",
            contentType: "application/json",
            data: JSON.stringify({
                "ticketId": ticket.ticket.ticket_id.toString()
            }),
            success:  function(formData) {
                response = jQuery.parseJSON(formData);

                if (response.success === false){
                    console.log("Ticket not found");
                }
                if (response.success === true){
                    console.log("CLOSED");
                    $('#closeTicket-modal').modal('toggle');

                    ticket.ticket.status = "Resolved";
                    replaceTicketStatus(ticket.ticket.status);
                }

            }
        });
        return false;

    });

    /* @JACQUI */
    /* THIS IS NOT WORKING :( */
    /* Update the status button in the table */
    $(".dropdown-menu li a").click(function(){

        var selectedStatus = $(this).text();

        function replaceClass(selectedStatus, newStatus) {
            $("#user-ticket-status").removeClass().addClass(newStatus);
            $("#user-ticket-status").find(".status-text").text(selectedStatus);
            sendStatus(selectedStatus);
        }

        if (selectedStatus === "In progress") {
            replaceClass(selectedStatus, "status status-in-progress white");
        }

        if (selectedStatus === "Pending") {
            replaceClass(selectedStatus, "status status-pending");
        }

        if (selectedStatus === "Resolved") {
            replaceClass(selectedStatus, "status status-resolved");
        }

        if (selectedStatus === "Unresolved") {
            replaceClass(selectedStatus, "status status-unresolved");
        }

    });

});


/* Send status to database */
function sendStatus(selectedStatus) {

    $.ajax({
        type: "POST",
        url: "/WDA/ticket/update",
        contentType: "application/json",
        data: JSON.stringify({ // FIXED! - dennis
            "ticket": {
                    "ticketId": ticket.ticket.ticket_id.toString(),
                    "status": selectedStatus.toLowerCase() // FIXED! - dennis
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

}
