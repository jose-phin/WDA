<?php
/**
 * Created by PhpStorm.
 * User: josephine
 * Date: 20/08/2016
 * Time: 5:08 PM
 */

/* Format of the request should be
    {
        "user":{
            "firstName":"John",
            "lastName":"Doe",
            "email":"poo@ko.com"
        },
        "comment":{
            "ticketId": 1,
            "comment": "comment here"
        }
    }
*/

    require('../classes/HandleRequest.php');
    //create a request Handler
    $requestHandler = new HandleRequest();

    //get the part of the url after .../ticket
    $endpoint = isset($_GET['endpoint'])? $_GET['endpoint'] : '';

    //if the url pointer to /comment/new, create a new ticket
    $response = null;
    switch($endpoint) {
        case "/new":
            $result = $requestHandler->createNewComment();
            $response = ($result == FALSE)
              ? array( "success" => $result )
              : array( "success" => TRUE, "commentId" => $result );
            break;
        case "/viewall" :
            $response = $requestHandler->viewTicketAndComments();
            break;
    };

    //don't send anything if the user didn't hit a valid endpoint
    if(isset($response)){
        echo json_encode($response);
    }

?>
