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



?>
