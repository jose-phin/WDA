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
    $result = null;
    switch($endpoint) {
        case "/new" :
            $result = $requestHandler->createNewComment();
            break;
    };

    //return the comment ID, if -1 is returned, it failed
    $response = array( "commentId" => $result );

    //don't send anything if the user didn't hit a valid endpoint
    if(isset($result)){
        $fp = fopen('../../WDA-Site/WDA-User/assets/results.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);
        echo json_encode($response);
    }

?>