<?php

  include($_SERVER['DOCUMENT_ROOT'].'\db\DatabaseHandler.php');

  //initialise the Database and the Database Handler
    $db = new DatabaseHandler("TestDatabase", TRUE);

    $testUser = $db->getUserByEmail("poo@ko.com");
    $postData = json_decode(file_get_contents('php://input'), TRUE);

    $user = $postData["user"];
    $ticket = $postData["ticket"];

    //check to see if the user EXISTS
    $testUser = $db->getUserByEmail($user["email"]);
    if (!isset($testUser)) {
      $db->createUser(
        $user['firstName'],
        $user['lastName'],
        $user['email'],
        FALSE
      );

    $testUser = $db->getUserByEmail($user["email"]);
    }

    $result = @$db->createTicket(
        $ticket['osType'],
        $ticket['primaryIssue'],
        $ticket['additionalNotes'],
        "pending",
        $testUser['user_id']
      );
    // echo var_dump($db->getTicket('1'));

    $response = array( "success" => $result );

    echo json_encode($response);
?>
