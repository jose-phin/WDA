<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '\classes\Api.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '\classes\HandleRequest.php';

  try {
    $API = new HandleRequest($_REQUEST, $_SERVER['REQUEST_URI']);
  } catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
  }

?>
