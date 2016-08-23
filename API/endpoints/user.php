<?php

  require('../classes/HandleRequest.php');
  //create a request Handler
  $requestHandler = new HandleRequest();

  //get the part of the url after .../user
  $endpoint = isset($_GET['endpoint'])? $_GET['endpoint'] : '';

  $result = null;
  switch($endpoint) {
    case "/new" :
      $result = $requestHandler->createUser();
      break;
  };

  //return the result of the user action
  $response = array( "success" => $result );

  //don't send anything if the user didn't hit a valid endpoint
  if(isset($result)){
    $fp = fopen('../../WDA-Site/WDA-User/assets/results.json', 'w');
    fwrite($fp, json_encode($response));
    fclose($fp);
    echo json_encode($response);
  }
?>
