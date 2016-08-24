<?php

/* Format of the request for
  /new
  {
    "user":{
        "firstName":"John",
        "lastName":"Doe",
        "email":"poo@ko.com"
    },
    "ticket":{
        "osType": "Mac",
        "primaryIssue": "Issue here",
        "additionalNotes": "Addition notes here"
    }
  }

  /view && /close
  {
    "ticketId": 1
  }

 */

  require('../classes/HandleRequest.php');
 //create a request Handler
  $requestHandler = new HandleRequest();

  //get the part of the url after .../ticket
  $endpoint = isset($_GET['endpoint'])? $_GET['endpoint'] : '';

  //if the url pointer to /ticket/new, create a new ticket
  $response = null;
  switch($endpoint) {
    case "/new" :
      $result = $requestHandler->createNewTicket();
      $response = ($result == FALSE)
        ? array( "success" => $result )
        : array( "success" => TRUE, "ticketId" => $result );
      break;
    case "/close" :
      $result = $requestHandler->closeTicket();
      $response = array( "success" => $result );
      break;
  };

  //don't send anything if the user didn't hit a valid endpoint
  if(isset($response)){
    echo json_encode($response);
  }
?>
