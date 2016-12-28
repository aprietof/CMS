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
        $html .= "<li>{$error}</li>";
      }
      $html .= "</ul>";
      $html .= "</div>";
    }
    return $html;
  }

  // PERFORM SUBJECTS DB QUERY
  function find_all_subjects() {

    global $db; #=> GLOBAL DATABASE

    // SUBJECTS QUERY
    $query = "SELECT * FROM subjects ORDER BY position ASC";
    $subjects_set = mysqli_query($db, $query); #=> collection of database rows
    confirm_query($subjects_set);
    return $subjects_set;
  }

  // RETURN SUBJECTS COUNT
  function subjects_count() {
    return mysqli_num_rows(find_all_subjects());
  }

  // PERFORM PAGES DB QUERY
  function find_all_pages($subject_id) {

    global $db; #=> GLOBAL DATABASE
    $safe_subject_id = mysqli_real_escape_string($db, $subject_id);

    $query = "SELECT * FROM pages
              WHERE visible = 1
              AND subject_id = {$safe_subject_id}
              ORDER BY position ASC";

    $pages_set = mysqli_query($db, $query); #=> collection of database rows
    return $pages_set;
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
          $output .= "<a href=\"manage_content.php?subject=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a>";

          // PERFORM PAGES DB QUERY
          $pages_set = find_all_pages($subject["id"]);
          confirm_query($pages_set);

          $output .= "<ul class=\"pages\">";

          while ($page = mysqli_fetch_assoc($pages_set)) { // increment the pointer
            // output data from each row
            $output .= "<li class=". selected_class($page_array["id"], $page) .">";
            $output .= "<a href=\"manage_content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
          }

          mysqli_free_result($pages_set); // RELEASE PAGES RETURNED DB

          $output .= "</ul>";
          $output .= "</li>";
        }

        mysqli_free_result($subjects_set); // RELEASE RETURNED DB
    $output .= "</ul>";
    return $output;
  }

  // PERFORM SUBJECT DB QUERY BY ID
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

  // PERFORM PAGE DB QUERY BY ID
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


  #### CRUD FUNCTIONS ####

  function update_subject($current_subject) {

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
        if($result && mysqli_affected_rows($db) == 1) {
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


?>
