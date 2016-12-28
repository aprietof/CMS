<?php

  // REDIRECT TO NEW PAGE
  function redirect_to($new_location) {
    header("Location: " . $new_location);
    exit;
  }

  // TEST IF QUERY ERROR
  function confirm_query ($result_set) {
    if(!$result_set) {
      die("Database query failed.");
    }
  }

  // DISPLAY FORM ERRORS
  function form_errors($errors) {
    $html = "";
    if (!empty($errors)) {
      $html .= "<div class='error'>";
      $html .= "<p>Please fix the following errors</p>";
      $html .= "<ul>";
      foreach ($errors as $key => $error) {
        $html .= "<li>" . htmlentities($error) . "</li>";
      }
      $html .= "</ul>";
      $html .= "</div>";
    }
    return $html;
  }

  // RETURN SUBJECTS COUNT
  function subjects_count() {
    return mysqli_num_rows(find_all_subjects());
  }

  // DEFINE SELECTED CLASS
  function selected_class($selected_page_id, $page){
    return $class = (isset($selected_page_id) && isset($page) && $selected_page_id == $page["id"]) ? "selected" : "";
  }

  // CHECK FOR PAGE CONTENT
  function find_selected_page() {
    global $current_subject;
    global $current_page;

    // set default values
    $current_subject = NULL;
    $current_page = NULL;

    if (isset($_GET["subject"])) {
      $current_subject = find_subject_by_id($_GET["subject"]);
    } elseif (isset($_GET["page"])) {
      $current_page = find_page_by_id($_GET["page"]);
    }
  }

  // RENDER NAVIGATION BAR (takes two arguments)
  # the currently selected subject array
  # the currently selected page array
  function navigation($subject_array, $page_array) {

    // PERFORM SUBJECTS DB QUERY
    $subjects_set = find_all_subjects();

    $output = "<ul class=\"subjects\">";

        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($subjects_set)) { // increment the pointer

          // output data from each row
          $output .= "<li class=" . selected_class($subject_array["id"], $subject) . ">";
          $output .= "<a href=\"manage_content.php?subject=" . urlencode($subject["id"]);
          $output .= "\">" . htmlentities($subject["menu_name"]) . "</a>";

          // PERFORM PAGES DB QUERY
          $pages_set = find_pages_for_subject($subject["id"]);
          confirm_query($pages_set);

          $output .= "<ul class=\"pages\">";

          while ($page = mysqli_fetch_assoc($pages_set)) { // increment the pointer
            // output data from each row
            $output .= "<li class=". htmlentities(selected_class($page_array["id"], $page)) .">";
            $output .= "<a href=\"manage_content.php?page=" . urlencode($page["id"]);
            $output .= "\">" . htmlentities($page["menu_name"]) . "</a></li>";
          }

          mysqli_free_result($pages_set); // RELEASE PAGES RETURNED DB

          $output .= "</ul>";
          $output .= "</li>";
        }

        mysqli_free_result($subjects_set); // RELEASE RETURNED DB
    $output .= "</ul>";
    return $output;
  }


  #----------- CRUD FUNCTIONS ----------- #

  // * SUBJECTS *

  // PERFORM SUBJECTS DATABASE QUERY
  function find_all_subjects() {

    global $db; #=> GLOBAL DATABASE

    // SUBJECTS QUERY
    $query = "SELECT * FROM subjects ORDER BY position ASC";
    $subjects_set = mysqli_query($db, $query); #=> collection of database rows
    confirm_query($subjects_set);
    return $subjects_set;
  }

  // PERFORM SUBJECT DATABASE QUERY BY ID
  function find_subject_by_id($subject_id) {

    global $db; #=> GLOBAL DATABASE
    $safe_subject_id = mysqli_real_escape_string($db, $subject_id); #=> prevents sql injection

    $query = "SELECT * FROM subjects WHERE id = {$safe_subject_id} LIMIT 1";
    $subject_set = mysqli_query($db, $query); #=> database row
    confirm_query($subject_set);
    if ($subject = mysqli_fetch_assoc($subject_set)) {
      return $subject;
    } else {
      return NULL;
    }
  }

  function create_subject() {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Data to INSERT
      $menu_name = $_POST["menu_name"];
      $position = (int) $_POST["position"];
      $visible = (int) $_POST["visible"];

      // Escape all strings for security and (" ' ") values
      $menu_name = mysqli_real_escape_string($db, $menu_name);

      // Validations
      $required_fields = array("menu_name", "position", "visible");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("menu_name" => 30);
      validate_max_lengths($fields_with_max_lengths);

      // Redirect if validation errors
      if (!empty($errors)) {

        // Add errors to session
        $_SESSION["errors"] = $errors;
        redirect_to("new_subject.php");
      }


      // Perform database query
      $query = "INSERT INTO subjects (menu_name, position, visible)
                VALUES ('{$menu_name}', {$position}, {$visible})";

      $result = mysqli_query($db, $query); // collection of database rows

      // Test if there was a query error
      if($result) {
        // Success
        $_SESSION["message"] = "Subject created.";
        redirect_to("manage_content.php");
      }
      else {
        // Failure
        $_SESSION["message"] = "Subject creation failed.";
        redirect_to("new_subject.php");
      }
    } else {
      // THIS IS PROBABLY A GET REQUEST
      redirect_to("new_subject.php");
    }
  }

  function update_subject($current_subject) {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Validations
      $required_fields = array("menu_name", "position", "visible");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("menu_name" => 30);
      validate_max_lengths($fields_with_max_lengths);


      if (empty($errors)) {

        // PERFORM UPDATE
        // Data to UPDATE
        $id = $current_subject["id"];
        $menu_name = $_POST["menu_name"];
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        // Escape all strings for security and (" ' ") values
        $menu_name = mysqli_real_escape_string($db, $menu_name);

        // Perform database query
        $query = "UPDATE subjects SET
                  menu_name = '{$menu_name}',
                  position = {$position},
                  visible = {$visible}
                  WHERE id = {$id}
                  LIMIT 1";

        $result = mysqli_query($db, $query); // collection of database rows

        // Test if there was a query error
        if($result && mysqli_affected_rows($db) >= 0) {
          // Success
          $_SESSION["message"] = "Subject updated.";
          redirect_to("manage_content.php?subject={$current_subject["id"]}");
        }
        else {
          // Failure
          $message = "Subject update failed.";
        }
      }

    } else {
      // THIS IS PROBABLY A GET REQUEST
    }
  }

  function delete_subject() {

    global $db;

    $current_subject = find_subject_by_id($_GET["subject"]);
    if (!$current_subject) { redirect_to("manage_content.php"); }

    $page_set = find_pages_for_subject($current_subject["id"]);

    // CHECK IF SUBJECT HAS PAGES AND STOP DELETION IF TRUE
    if (mysqli_num_rows($page_set) > 0) {
      $_SESSION["message"] = "Can't delete subject with pages.";
      redirect_to("manage_content.php?subject={$current_subject["id"]}");
    }

    $id = $current_subject["id"];
    $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";

    $result = mysqli_query($db, $query);

    // TEST IF THERE WAS A QUERY ERROR
    if($result && mysqli_affected_rows($db) == 1) {
      // Success
      $_SESSION["message"] = "Subject deleted.";
      redirect_to("manage_content.php");
    }
    else {
      // Failure
      $_SESSION["message"] = "Subject deletion failed.";
      redirect_to("manage_content.php?subject={$id}");
    }
  }

  // * PAGES *

  // PERFORM PAGES DATABASE QUERY
  function find_pages_for_subject($subject_id) {

    global $db; #=> GLOBAL DATABASE
    $safe_subject_id = mysqli_real_escape_string($db, $subject_id);

    $query = "SELECT * FROM pages
              WHERE visible = 1
              AND subject_id = {$safe_subject_id}
              ORDER BY position ASC";

    $pages_set = mysqli_query($db, $query); #=> collection of database rows
    return $pages_set;
  }

  // PERFORM PAGE DATABASE QUERY BY ID
  function find_page_by_id($page_id) {

    global $db; #=> GLOBAL DATABASE
    $safe_page_id = mysqli_real_escape_string($db, $page_id); #=> prevents sql injection

    $query = "SELECT * FROM pages WHERE id = {$safe_page_id} LIMIT 1";
    $page_set = mysqli_query($db, $query); #=> database row
    confirm_query($page_set);
    if ($page = mysqli_fetch_assoc($page_set)) {
      return $page;
    } else {
      return NULL;
    }
  }

?>
