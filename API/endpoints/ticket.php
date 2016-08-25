<?php

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
    case "/view" :
      $result = $requestHandler->viewTicketAndComments();
      $response = (isset($result['ticketInfo']) && $result['ticketInfo'] != FALSE)
        ? array( "success" => TRUE, "ticket" => $result['ticketInfo'] )
        : array( "success" => FALSE );
      break;
  };

  //don't send anything if the user didn't hit a valid endpoint
  if(isset($response)){
    echo json_encode($response);
  }
?>
