$(document).ready(function(){
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
        url: "/WDA/ticket/view",
        contentType: 'application/json',
        data: JSON.stringify({
            "ticketId": ticketID.toString()
        }),
        success:  function(formData) {
            var ticket = jQuery.parseJSON(formData);
            if (ticket.success === false){
                console.log("ticket not found");
            }
            if (ticket.success === true){
                console.log(ticket.ticket);
                $(".user-ticket-ticketTitle").val();
            }
        }
    });
    return false;



});
