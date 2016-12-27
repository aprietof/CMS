<?php
  session_start();

  // DISPLAY SESSION MESSAGE
  function message() {
    if (isset($_SESSION["message"])) {
      $output = "<div class=\"message\">" . htmlentities($_SESSION["message"]) . "</div>";
      $_SESSION["message"] = NULL;
      return $output;
    }
  }


?>
