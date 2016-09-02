/* View all tickets */

$(document).ready(function() {

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
                console.log(tickets);
                tickets.tickets.forEach(function(element){

                    var tableRowStart = "<tr>";
                    var tableRowEnd = "</tr>";
                    var ticketId = "<td>" + element.ticket_id + "</td>";
                    var userID = element.submitter_id;
                    var email = element.email;
                    var primaryIssue = element.subject;

                    var subject  = "<td><span class=\"ticket-name\">" + primaryIssue + "<br></span>" +
                                        "<span class=\"small\">" + " #" + userID + " (" + email + ")</span></td>";

                    var status = "<td><span class=\"status status-"+element.status.toLowerCase()+"\"><i class='fa fa-circle fa-1 fa-statusTag' aria-hidden='true'></i>" + element.status + "</span></td>"; /* By default, pending */
                    var category = "<td>" + element.primary_issue + "</td>";
                    var os = "<td>" + element.os_type + "</td>";

                    var additionalNotes = element.additional_notes;

                    $("#table-body").append(tableRowStart + ticketId + subject + category + os + status + tableRowEnd);

                });

            }

        }
    });

});
