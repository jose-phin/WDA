/* View all tickets */

$(document).ready(function() {

    console.log("view-all-tickets.js");

    $.ajax({
        type: "POST",
        url: "/WDA/ticket/viewAll",
        contentType: "application/json",
        success:  function(response) {

            tickets = jQuery.parseJSON(response);

            if (tickets.success === false) {
                /* Error handling */
                console.log("Something went wrong...");
            }

            if (tickets.success === true) {

                var ticketArray = tickets.ticket;

                for (var i = 0; i < ticketArray.length; i++) {

                    var tableRowStart = "<tr>";
                    var tableRowEnd = "</tr>";
                    var ticketId = "<td>" + ticketArray[i].ticket_id + "</td>";
                    var userID = ticketArray[i].submitter_id;
                    var email = ticketArray[i].email;
                    var primaryIssue = ticketArray[i].subject; 

                    var subject  = "<td><span class=\"ticket-name\">" + primaryIssue + "<br></span>" + 
                                        "<span class=\"small\">" + " #" + userID + " (" + email + ")</span></td>";

                    var status = "<td><span class=\"status status-pending\">" + ticketArray[i].status + "</span></td>"; /* By default, pending */
                    var category = "<td>" + ticketArray[i].primary_issue + "</td>";
                    var os = "<td>" + ticketArray[i].os_type + "</td>";

                    var additionalNotes = ticketArray[i].additional_notes;

                    $("#table-body").append(tableRowStart + ticketId + subject + category + os + status + tableRowEnd);

                }

            }

        }
    });

});