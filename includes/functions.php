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
    $query = "SELECT * FROM subjects WHERE visible = 1";
    $subjects_set = mysqli_query($db, $query); #=> collection of database rows
    return $subjects_set;
  }

  // PERFORM PAGES DB QUERY
  function find_all_pages($subject_id) {

    global $db; #=> GLOBAL DATABASE

    $query = "SELECT * FROM pages
              WHERE visible = 1
              AND subject_id = {$subject_id}
              ORDER BY position ASC";

    $pages_set = mysqli_query($db, $query); #=> collection of database rows
    return $pages_set;
  }

  // DEFINE SELECTED CLASS
  function selected_class($selected, $page){
    return $class = (isset($selected) && isset($page) && $selected == $page["id"]) ? "selected" : "";
  }

  // RENDER NAVIGATION BAR (takes two arguments)
  # the currently selected subject ID (if any)
  # the currently selected page ID (if any)
  function navigation($subject_id, $page_id) {

    // PERFORM SUBJECTS DB QUERY
    $subjects_set = find_all_subjects();
    confirm_query($subjects_set);

    $output = "<ul class=\"subjects\">";

        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($subjects_set)) { // increment the pointer

          // output data from each row
          $output .= "<li class=" . selected_class($subject_id, $subject) . ">";
          $output .= "<a href=\"manage_content.php?subject=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a>";

          // PERFORM PAGES DB QUERY
          $pages_set = find_all_pages($subject["id"]);
          confirm_query($pages_set);

          $output .= "<ul class=\"pages\">";

          while ($page = mysqli_fetch_assoc($pages_set)) { // increment the pointer
            // output data from each row
            $output .= "<li class=". selected_class($page_id, $page) .">";
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

?>
