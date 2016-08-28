// This javascript file retrieves json data from DB
// and populate the page with data
var ticket, comments;
$(document).ready(function(){

    $(".ticket-notFound-message").hide();
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('?');

    if (sURLVariables.length > 1){
        console.warn("Too many variables");
    }
    else{
        var ticketID = sURLVariables[0].split('=')[1];
    }


    $.ajax({
        type: "POST",
        url: "/WDA/ticket/ticketUser",
        contentType: 'application/json',
        data: JSON.stringify({
            "ticketId": ticketID.toString()
        }),
        success:  function(formData) {

            ticket = jQuery.parseJSON(formData);
            if (ticket.success === false){
                console.log("ticket not found");
                $(".user-ticket-ticketTitle").text("Ticket does not exist.");
                $(".user-ticket-ticketId").hide();
                $(".ticket-notFound-message").show();
                $(".status").hide();
                $(".ticket-content-container").hide();
            }
            if (ticket.success === true){
                console.log(ticket.ticket);
                $(".user-ticket-ticketTitle").text(ticket.ticket.subject);
                $(".user-ticket-ticketId").text("Ticket ID: #"+ticket.ticket.ticket_id);

                console.log(ticket.user);
                $(".user-ticket-fullName").text(ticket.user.first_name+" "+ticket.user.last_name);
                $(".user-ticket-issueCategory").text(ticket.ticket.primary_issue);
                $(".user-ticket-osType").text(ticket.ticket.os_type);
                
                var additionalNotes = ticket.ticket.additional_notes.replace(/(\r\n|\n|\r)/g,"<br />");
                $(".user-ticket-originalMessage").html(additionalNotes);

                // Set ticket status
                replaceTicketStatus(ticket.ticket.status);
                getAllReplies();
            }
        }
    });
    return false;



});


function replaceTicketStatus($ticketStatus){
    $('.status').replaceWith("<span class='status "+"status-"+$ticketStatus+" user-ticket-status'>"+$ticketStatus+"</span>");
}
