<?php
  //shamelessly 'inspired' by this post
  //http://stackoverflow.com/questions/27381520/php-built-in-server-and-htaccess-mod-rewrites
  if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
  } else {
    include $_SERVER['DOCUMENT_ROOT'] . '\endpoints\test.php';
  }
?>
