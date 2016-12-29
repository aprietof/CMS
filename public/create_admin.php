<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php create_admin(); // CREATE ADMIN IN DATABASE ?>
<?php if (isset($db)) { mysqli_close($db); } // CLOSE DB CONNECTION (IF ANY) ?>
