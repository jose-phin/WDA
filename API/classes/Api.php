<?php
  abstract class Api {

    public function __construct($request, $url) {
      $delimUrl = explode("?", $url);
      echo 'Recieved request for endpoint: ' . $delimUrl[0] . "\n";
      echo "contents of request: \n";
      echo var_dump($request);
    }
  }
?>
