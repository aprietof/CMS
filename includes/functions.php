<?php

  // TEST IF QUERY ERROR
  function confirm_query ($result_set) {
    if(!$result_set) {
      die("Database query failed.");
    }
  }

  // PERFORM SUBJECTS DB QUERY
  function find_all_subjects() {

    global $db; #=> GLOBAL DATABASE

    // PERFORM SUBJECTS DB QUERY
    $query = "SELECT * FROM subjects ORDER BY position ASC";
    $subjects_set = mysqli_query($db, $query); #=> collection of database rows
    confirm_query($subjects_set);
    return $subjects_set;
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
  function selected_class($selected, $page){
    return $class = (isset($selected) && isset($page) && $selected == $page["id"]) ? "selected" : "";
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

?>
