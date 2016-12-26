<?php
  // 1. Create a database connection
  define("DB_SERVER", "localhost");
  define("DB_USER", "adrian");
  define("DB_PASS", "password");
  define("DB_NAME", "widget_corp");
  $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

  // Test if connection occurred
  if(mysqli_connect_errno()) {
    die("Database connecton failed: " .
    mysqli_connect_error() . " (" .
    mysqli_connect_errno() . ") ");
  }
?>
