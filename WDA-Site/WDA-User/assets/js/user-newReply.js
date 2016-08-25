$(document).ready(function(){

    // Validation
    $("#add-comment-form").validate({
        rules: {
            newMessage: {
                required: true
            },
        },
        messages: {
            newMessage: {
                required: "You can't leave the reply blank."
            }
        }
    });


    // Process form
    $(document).submit("#add-comment-form", function(e) {
        e.preventDefault();
        console.log(ticket.ticket.ticket_id);
        /* Serialised data */
        var data = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "/WDA/comment/new",
            contentType: 'application/json',
            data: JSON.stringify({
                "user":{
                    "email": "john@apple.com"
                },
                "comment":{
                    "ticketId": ticket.ticket.ticket_id,
                    "comment": $("#newMessage").val()
                }

            }),
            success:  function(formData) {
                var comment = jQuery.parseJSON(formData);
                if (comment.success === false){
                    console.log("Error submitting comment");
                }
                if (comment.success === true){
                    showLatestReply();
                    $("#newMessage").val('');
                }
            }
        });
        return false;
    });

});


function getAllReplies(){
    $.ajax({
        type: "POST",
        url: "/WDA/comment/viewall",
        contentType: 'application/json',
        data: JSON.stringify({
            "ticketId": ticket.ticket.ticket_id
        }),
        success:  function(formData) {
            comments = jQuery.parseJSON(formData);
            if (comments.success === false){
                console.log("Error showing comment");
            }
            if (comments.success === true){
                displayAllReplies();
            }
        }
    });
    return false;
}


function displayAllReplies(){

    $newHtmlRowHead = '<div class="new-reply-container"><legend class="reply-separator"></legend><p class="col-md-12 ticket-info-header-text">{{Full Name}} added:</p><p class="col-md-12 new-reply-text">';
    $newHtmlRowTail = '</p></div>';
    $.each(comments.comments, function(i, item){
        $(".reply-main-container").append(
            $newHtmlRowHead+item.comment_text+$newHtmlRowTail
        );

    });
}


function showLatestReply(){
    $.ajax({
        type: "POST",
        url: "/WDA/comment/viewall",
        contentType: 'application/json',
        data: JSON.stringify({
            "ticketId": ticket.ticket.ticket_id
        }),
        success:  function(formData) {
            comments = jQuery.parseJSON(formData);
            if (comments.success === false){
                console.log("Error showing comment");
            }
            if (comments.success === true){
                var totalComments = comments.comments.length;

                $newHtmlRowHead = '<div class="new-reply-container"><legend class="reply-separator"></legend><p class="col-md-12 ticket-info-header-text">{{Full Name}} added:</p><p class="col-md-12 new-reply-text">';
                $newHtmlRowTail = '</p></div>';

                $(".reply-main-container").append($newHtmlRowHead+comments.comments[totalComments-1].comment_text+$newHtmlRowTail);
            }
        }
    });
    return false;

}
