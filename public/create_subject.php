<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>

<?php // CHECK IF FORM WAS SUBMITED

  if (isset($_POST["submit"])) {

    // Data to INSERT
    $menu_name = $_POST["menu_name"];
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    // Escape all strings for security and (" ' ") values
    $menu_name = mysqli_real_escape_string($db, $menu_name);

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
?>


<?php if (isset($db)) { mysqli_close($db); } // CLOSE DB CONNECTION (IF ANY) ?>
