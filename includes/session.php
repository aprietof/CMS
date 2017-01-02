<?php
  session_start();

  // DISPLAY SESSION MESSAGE
  function message() {
    if (isset($_SESSION["message"])) {

      $output = "<br /><div class=\"alert alert-dismissible alert-success\">";
      $output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
      $output .= htmlentities($_SESSION["message"]);
      $output .= "</div>";

      // Clear message after use
      $_SESSION["message"] = NULL;

      return $output;
    }
  }

  // STORE SESSION ERRORS
  function errors() {
    if (isset($_SESSION["errors"])) {
      $errors = $_SESSION["errors"];

      // Clear errors after use
      $_SESSION["errors"] = NULL;

      return $errors;
    }
  }


?>
