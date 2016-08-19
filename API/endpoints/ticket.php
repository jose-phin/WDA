<?php

  require($_SERVER['DOCUMENT_ROOT'].'\API\classes\HandleRequest.php');

  //create a request Handler
  $requestHandler = new HandleRequest();

  //get the part of the url after .../ticket
  $endpoint = $_GET['endpoint'];

  //if the url pointer to /ticket/new, create a new ticket
  $result = null;
  switch($endpoint) {
    case "/new" :
      $result = $requestHandler->createNewTicket();
      break;
  };

  //return the result of the ticket creation
  $response = array( "success" => $result );

  //don't send anything if the user didn't hit a valid endpoint
  if(isset($result)) echo json_encode($response);
?>
