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
      $html .= "<br />";
      $html .= "<div class=\"alert alert-dismissible alert-danger\">";
      $html .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
      $html .= "<p>Please fix the following errors and try submitting again.</p><br/>";
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
    return mysqli_num_rows(find_all_subjects(false));
  }


  // RETURN PAGES COUNT
  function pages_count($subject_id) {
    return mysqli_num_rows(find_pages_for_subject($subject_id, false));
  }


  // DEFINE SELECTED CLASS
  function selected_class($selected_page_id, $page){
    return $class = (isset($selected_page_id) && isset($page) && $selected_page_id == $page["id"]) ? "selected" : "";
  }


  // FIND DEFAULT PAGE FOR SUBJECT (First Page)
  function find_default_page_for_subject($subject_id) {
    $page_set = find_pages_for_subject($subject_id);

    if ($first_page = mysqli_fetch_assoc($page_set)) {
      return $first_page;
    } else {
      return NULL;
    }
  }


  // CHECK FOR PAGE CONTENT (Takes T/F for public visibility)
  function find_selected_page($public=false) {
    global $current_subject;
    global $current_page;

    // set default values
    $current_subject = NULL;
    $current_page = NULL;

    if (isset($_GET["subject"])) {
      $current_subject = find_subject_by_id($_GET["subject"], $public);
      if ($current_subject && $public) {
        $current_page = find_default_page_for_subject($_GET["subject"]);
      }
    } elseif (isset($_GET["page"])) {
      $current_page = find_page_by_id($_GET["page"], $public);
    }
  }


  // RENDER ADMIN NAVIGATION (takes two arguments)
  # the currently selected subject array
  # the currently selected page array
  function navigation($subject_array, $page_array) {

    // PERFORM SUBJECTS DB QUERY
    $subjects_set = find_all_subjects(false);

    $output = "<ul class=\"subjects\">";

        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($subjects_set)) { // increment the pointer

          // output data from each row
          $output .= "<li class=" . selected_class($subject_array["id"], $subject) . ">";
          $output .= "<a href=\"manage_content.php?subject=" . urlencode($subject["id"]);
          $output .= "\">" . htmlentities($subject["menu_name"]) . "</a>";

          // PERFORM PAGES DB QUERY
          $pages_set = find_pages_for_subject($subject["id"], false);
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



  // RENDER PUBLIC NAVIGATION (takes two arguments)
  function public_navigation($subject_array, $page_array) {

    // PERFORM SUBJECTS DB QUERY
    $subjects_set = find_all_subjects();

    $output = "<ul class=\"subjects\">";

        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($subjects_set)) { // increment the pointer

          // output data from each row
          $output .= "<li class=" . selected_class($subject_array["id"], $subject) . ">";
          $output .= "<a href=\"index.php?subject=" . urlencode($subject["id"]);
          $output .= "\">" . htmlentities($subject["menu_name"]) . "</a>";

          if ($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) { // Accordion effect
            // PERFORM PAGES DB QUERY
            $pages_set = find_pages_for_subject($subject["id"]);
            confirm_query($pages_set);

            $output .= "<ul class=\"pages\">";

            while ($page = mysqli_fetch_assoc($pages_set)) { // increment the pointer
              // output data from each row
              $output .= "<li class=". htmlentities(selected_class($page_array["id"], $page)) .">";
              $output .= "<a href=\"index.php?page=" . urlencode($page["id"]);
              $output .= "\">" . htmlentities($page["menu_name"]) . "</a></li>";
            }
            $output .= "</ul>";
            mysqli_free_result($pages_set); // RELEASE PAGES RETURNED DB
          }
          $output .= "</li>"; // END OF SUBJECT <li>
        }

        mysqli_free_result($subjects_set); // RELEASE RETURNED DB
    $output .= "</ul>";
    return $output;
  }


  #----------- CRUD FUNCTIONS ----------- #


  // * SUBJECTS *

  // PERFORM SUBJECTS DATABASE QUERY
  // (takes context argument T/F)
  function find_all_subjects($public=true) {

    global $db; #=> GLOBAL DATABASE

    // SUBJECTS QUERY
    $query = "SELECT * FROM subjects ";
    if ($public) {
      $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $subjects_set = mysqli_query($db, $query); #=> collection of database rows
    confirm_query($subjects_set);
    return $subjects_set;
  }


  // PERFORM SUBJECT DATABASE QUERY BY ID
  function find_subject_by_id($subject_id, $public=true) {

    global $db; #=> GLOBAL DATABASE
    $safe_subject_id = mysqli_real_escape_string($db, $subject_id); #=> prevents sql injection

    $query = "SELECT * FROM subjects WHERE id = {$safe_subject_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $subject_set = mysqli_query($db, $query); #=> database row
    confirm_query($subject_set);
    if ($subject = mysqli_fetch_assoc($subject_set)) {
      return $subject;
    } else {
      return NULL;
    }
  }


  // CREATE SUBJECT
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


  // UPDATE SUBJECT
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


  // DELETE SUBJECT
  function delete_subject() {

    global $db;

    $current_subject = find_subject_by_id($_GET["subject"], false);
    if (!$current_subject) { redirect_to("manage_content.php"); }

    $page_set = find_pages_for_subject($current_subject["id"], false);

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
  // Takes two args subject id and context(T/F)
  function find_pages_for_subject($subject_id, $public=true) {

    global $db; #=> GLOBAL DATABASE
    $safe_subject_id = mysqli_real_escape_string($db, $subject_id);

    $query = "SELECT * FROM pages ";
    $query .= "WHERE subject_id = {$safe_subject_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
    $query .= "ORDER BY position ASC";

    $pages_set = mysqli_query($db, $query); #=> collection of database rows
    return $pages_set;
  }

  // PERFORM PAGE DATABASE QUERY BY ID
  function find_page_by_id($page_id, $public=true) {

    global $db; #=> GLOBAL DATABASE
    $safe_page_id = mysqli_real_escape_string($db, $page_id); #=> prevents sql injection

    $query = "SELECT * FROM pages WHERE id = {$safe_page_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $page_set = mysqli_query($db, $query); #=> database row
    confirm_query($page_set);
    if ($page = mysqli_fetch_assoc($page_set)) {
      return $page;
    } else {
      return NULL;
    }
  }


  // CREATE PAGE
  function create_page() {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Data to INSERT
      $menu_name = $_POST["menu_name"];
      $position = (int) $_POST["position"];
      $visible = (int) $_POST["visible"];
      $content =  $_POST["content"];
      $subject_id = $_GET["subject"];

      // Escape all strings for security and (" ' ") values
      $menu_name = mysqli_real_escape_string($db, $menu_name);
      $content = mysqli_real_escape_string($db, $content);

      // Validations
      $required_fields = array("menu_name", "position", "visible", "content");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("menu_name" => 30);
      validate_max_lengths($fields_with_max_lengths);

      // Redirect if validation errors
      if (!empty($errors)) {

        // Add errors to session
        $_SESSION["errors"] = $errors;
        redirect_to("new_page.php?subject={$subject_id}");
      }

      // Perform database query
      $query = "INSERT INTO pages (subject_id, menu_name, position, visible, content)
                VALUES ({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
      $result = mysqli_query($db, $query); // collection of database rows

      // Test if there was a query error
      if($result) {
        // Success
        $_SESSION["message"] = "Page created.";
        redirect_to("manage_content?subject={$subject_id}");
      }
      else {
        // Failure
        $_SESSION["message"] = "Page creation failed.";
        redirect_to("new_page.php?subject={$subject_id}");
      }
    } else {
      // THIS IS PROBABLY A GET REQUEST
      redirect_to("manage_content.php");
    }
  }


  // UPDATE PAGE
  function update_page($current_page) {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Validations
      $required_fields = array("menu_name", "position", "visible", "position");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("menu_name" => 30);
      validate_max_lengths($fields_with_max_lengths);


      if (empty($errors)) {

        // PERFORM UPDATE
        // Data to UPDATE
        $id = $current_page["id"];
        $subject_id = $current_page["subject_id"];
        $menu_name = $_POST["menu_name"];
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        $content = $_POST["content"];

        // Escape all strings for security and (" ' ") values
        $menu_name = mysqli_real_escape_string($db, $menu_name);
        $content = mysqli_real_escape_string($db, $content);

        // Perform database query
        $query = "UPDATE pages SET
                  subject_id = {$subject_id},
                  menu_name = '{$menu_name}',
                  position = {$position},
                  visible = {$visible},
                  content = '{$content}'
                  WHERE id = {$id}
                  LIMIT 1";

        $result = mysqli_query($db, $query); // collection of database rows

        // Test if there was a query error
        if($result && mysqli_affected_rows($db) >= 0) {
          // Success
          $_SESSION["message"] = "Page updated.";
          redirect_to("manage_content.php?page={$current_page["id"]}");
        }
        else {
          // Failure
          $message = "Page update failed.";
        }
      }

    } else {
      // THIS IS PROBABLY A GET REQUEST
    }
  }


  // DELETE PAGE
  function delete_page() {

    global $db;

    $current_page = find_page_by_id($_GET["page"], false);
    if (!$current_page) { redirect_to("manage_content.php"); }

    $id = $current_page["id"];
    $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";

    $result = mysqli_query($db, $query);

    // TEST IF THERE WAS A QUERY ERROR
    if($result && mysqli_affected_rows($db) == 1) {
      // Success
      $_SESSION["message"] = "Page deleted.";
      redirect_to("manage_content.php");
    }
    else {
      // Failure
      $_SESSION["message"] = "Page deletion failed.";
      redirect_to("manage_content.php?page={$id}");
    }
  }


  // * ADMINS *


  // FIND ALL ADMINS
  function find_all_admins() {

    global $db;

    // ADMINS QUERY
    $query = "SELECT * FROM admins ORDER BY username ASC";
    $admin_set = mysqli_query($db, $query); #=> collection of database rows
    confirm_query($admin_set);
    return $admin_set;
  }


  // FIND ADMIN BY ID
  function find_admin_by_id($admin_id) {

    global $db;

    $safe_admin_id = mysqli_real_escape_string($db, $admin_id); #=> prevents sql injection

    $query = "SELECT * FROM admins WHERE id = {$safe_admin_id} LIMIT 1";
    $admin_set = mysqli_query($db, $query); #=> database row
    confirm_query($admin_set);
    if ($admin = mysqli_fetch_assoc($admin_set)) {
      return $admin;
    } else {
      return NULL;
    }
  }


  // FIND ADMIN BY USERNAME
  function find_admin_by_username($username) {

    global $db;

    $safe_admin_id = mysqli_real_escape_string($db, $username); #=> prevents sql injection

    $query = "SELECT * FROM admins WHERE username = '{$safe_admin_id}' LIMIT 1";
    $admin_set = mysqli_query($db, $query); #=> database row
    confirm_query($admin_set);
    if ($admin = mysqli_fetch_assoc($admin_set)) {
      return $admin;
    } else {
      return NULL;
    }
  }


  // CREATE ADMIN
  function create_admin() {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Data to INSERT
      $username = $_POST["username"];
      $password = $_POST["password"];

      // Escape all strings for security and (" ' ") values
      $username = mysqli_real_escape_string($db, $username);
      $hashed_password = password_encrypt($password);

      // Validations
      $required_fields = array("username", "password");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("username" => 30);
      validate_max_lengths($fields_with_max_lengths);

      // Redirect if validation errors
      if (!empty($errors)) {

        // Add errors to session
        $_SESSION["errors"] = $errors;
        redirect_to("new_admin.php");
      }

      // Perform database query
      $query = "INSERT INTO admins (username, hashed_password)
                VALUES ('{$username}', '{$hashed_password}')";
      $result = mysqli_query($db, $query); // collection of database rows

      // Test if there was a query error
      if($result) {
        // Success
        $_SESSION["message"] = "Admin created.";
        redirect_to("manage_admins.php");
      }
      else {
        // Failure
        $_SESSION["message"] = "Admin creation failed.";
        redirect_to("new_admin.php");
      }
    } else {
      // THIS IS PROBABLY A GET REQUEST
      redirect_to("new_admin.php");
    }
  }


  // UPDATE ADMIN
  function update_admin($current_admin) {

    global $errors;
    global $db;

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Validations
      $required_fields = array("username", "password");
      validate_precences($required_fields);

      $fields_with_max_lengths = array("username" => 30);
      validate_max_lengths($fields_with_max_lengths);


      if (empty($errors)) {

        // PERFORM UPDATE
        // Data to UPDATE
        $id = $current_admin["id"];
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Escape all strings for security and (" ' ") values
        $username = mysqli_real_escape_string($db, $username);
        $hashed_password = password_encrypt($password);

        // Perform database query
        $query = "UPDATE admins SET
                  username = '{$username}',
                  hashed_password = '{$hashed_password}'
                  WHERE id = {$id}
                  LIMIT 1";

        $result = mysqli_query($db, $query); // collection of database rows

        // Test if there was a query error
        if($result && mysqli_affected_rows($db) >= 0) {
          // Success
          $_SESSION["message"] = "Admin updated.";
          redirect_to("manage_admins.php");
        }
        else {
          // Failure
          $message = "Admin update failed.";
        }
      }

    } else {
      // THIS IS PROBABLY A GET REQUEST
    }
  }


  // DELETE ADMIN
  function delete_admin($admin_id) {

    global $db;

    $current_admin = find_admin_by_id($_GET["id"]);
    if (!$current_admin) { redirect_to("manage_admins.php"); }

    $id = $current_admin["id"];
    $query = "DELETE FROM admins WHERE id = {$id} LIMIT 1";

    $result = mysqli_query($db, $query);

    // TEST IF THERE WAS A QUERY ERROR
    if($result && mysqli_affected_rows($db) == 1) {
      // Success
      $_SESSION["message"] = "admin deleted.";
      redirect_to("manage_admins.php");
    }
    else {
      // Failure
      $_SESSION["message"] = "admin deletion failed.";
      redirect_to("manage_admins.php");
    }
  }


  // * PASSWORD ENCRYPTION *


  // ENCRYPT PASSWORD USING BLOWFISH ALGORITHM AND SALT
  function password_encrypt($password) {

    // Tells PHP to use Blowfish algorithm
    // with a "cost" of 10
    $hash_format = "$2y$10$";

    // Blowfish salts should be 22 characters or more
    $salt_length = 22;

    $salt = generate_salt($salt_length);
    $format_nad_salt = $hash_format . $salt;
    $hash = crypt($password, $format_nad_salt);
    return $hash;
  }


  // GENERATE SALT FOR PASSWORD ENCRYPTION
  function generate_salt($length) {

    // Not 100% unique not 100% random but good enough for salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));

    // Valid characters for salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    // but not '+' which is valid in base 64 encoding
    $modified_base64_string = str_replace("+", ".", $base64_string);

    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);

    return $salt;
  }


  // CHECK IF ENTERED PASSWORD MATCHES DB ENCRYPTED PASSWORD
  function password_check($password, $existing_hash) {

    // Existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);

    if ($hash === $existing_hash ) {
      return true;
    } else {
      return false;
    }
  }


  // ADMIN LOGIN
  function login() {

    global $username;
    global $errors;
    global $db;

    $username = "";

    // CHECK IF FORM WAS SUBMITED
    if (isset($_POST["submit"])) {

      // Data to INSERT
      $username = $_POST["username"];
      $password = $_POST["password"];

      // Escape all strings for security and (" ' ") values
      $username = mysqli_real_escape_string($db, $username);
      $hashed_password = password_encrypt($password);

      // Validations
      $required_fields = array("username", "password");
      validate_precences($required_fields);

      // Redirect if validation errors
      if (!empty($errors)) {

        // Add errors to session
        $_SESSION["errors"] = $errors;
        redirect_to("login.php");
      }

      // Perform database query (look for admin in DB)
      $found_admin = attepmt_login($username, $password);

      // Test if there was a query error
      if($found_admin) {
        // Success
        $_SESSION["username"] = $found_admin["username"];
        $_SESSION["admin_id"] = $found_admin["id"];
        redirect_to("admin.php");
      }
      else {
        // Failure
        $_SESSION["message"] = "Usernmae/password not found.";
        redirect_to("login.php");
      }
    } else {
      // THIS IS PROBABLY A GET REQUEST
    }
  }


  // CHECK IF PASSWORD AND USERNAME'S PASSWORD MATCH
  function attepmt_login($username, $password) {

    // Find admin
    $admin = find_admin_by_username($username);

    if ($admin) {
      // look for password
      // if password matches return admin
      if (password_check($password, $admin["hashed_password"])) {
        return $admin;
      } else {
        // Password does not match
        return false;
      }
    } else {
      // admin not found
      return false;
    }
  }


  // RETURNS IF USER IS LOGGED IN (T/F)
  function logged_in() {
    return isset($_SESSION["admin_id"]);
  }

  // REDIRECT TO LOGIN IF USER IS NOT LOGGED IN
  function redirect_if_not_logged_in() {
    if(!logged_in()) {
      redirect_to("login.php");
    }
  }


  // LOGOUT
  function logout() {
    $_SESSION = array();
    $_SESSION["message"] = "Logout succsesfuly";
    redirect_to("login.php");
  }

?>
