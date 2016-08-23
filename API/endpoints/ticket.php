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
  $result = null;
  switch($endpoint) {
    case "/new" :
      $result = $requestHandler->createNewTicket();
      break;
    case "/view" :
      $result = $requestHandler->viewTicketAndComments();
      break;
    case "/close" :
      $result = $requestHandler->closeTicket();
      break;
  };

  //return the result of the ticket creation
  $response = array( "success" => $result );

  //don't send anything if the user didn't hit a valid endpoint
  if(isset($result)){
    $fp = fopen('../../WDA-Site/WDA-User/assets/results.json', 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);
    echo json_encode($response);
  }
?>
