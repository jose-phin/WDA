<?php

  try {
    echo 'Deleting Ticket with params\n';
    echo var_dump($_REQUEST);
  } catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
  }
?>
