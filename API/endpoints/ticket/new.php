<?php

  include($_SERVER['DOCUMENT_ROOT'].'\db\DatabaseHandler.php');

  //initialise the Database and the Database Handler
    $db = new DatabaseHandler("TestDatabase", TRUE);

    $db->createUser("John", "Doe", "poo@ko.com", FALSE);

    $testUser = $db->getUserByEmail("poo@ko.com");
    $postData = json_decode(file_get_contents('php://input'), TRUE);

    $db->createTicket($postData['osType'], $postData['primaryIssue'], $postData['additionalNotes'], "pending", $testUser['user_id']);
    echo var_dump($db->getTicket('1'));

  // create new DatabaseHandler($name, TRUE)
  // Dbhandler->setUpTables()
  // db->createUser($fName, $lName, $email, FALSE) <- remove this later
  // db->createTcket($osType, $primatyIssue, $assitionalNotes, $status, $userID)
  // send response back to user with success/fail
?>
