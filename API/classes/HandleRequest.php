<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '\classes\Api.php';

  class HandleRequest extends Api{

    public function __construct($request, $url) {
      parent::__construct($request, $url);
    }
  }
?>
