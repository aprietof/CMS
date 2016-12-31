<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php $current_admin = find_admin_by_id($_GET["id"]); // CHECK FOR ADMIN ID ?>
<?php if (!$current_admin) {redirect_to("manage_admins.php");} // REDIRECT IF SUBJECT NOT FOUND ?>
<?php update_admin($current_admin); // UPDATE ADMIN IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">

    <?php if (!empty($message)) { echo "<div class=\"message\">" . htmlentities($message) . "</div>"; } // ERROR MESSAGE (IF ANY) ?>
    <?php echo form_errors($errors); // FORM ERRORS (IF ANY) ?>

    <h2>Edit Admin <?php echo htmlentities($current_admin["username"]); ?></h2>

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>

    <form action="edit_admin.php?id=<?php echo htmlentities($current_admin["id"]); ?>" method="post">

      <p>
        Username: <br />
        <input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]); ?>">
      </p>

      <p>
        Password: <br />
        <input type="password" name="password" value="">
      </p>

      <input type="submit" name="submit" value="Update admin">

    </form>

    <a href="manage_admins.php">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_admin.php?id=<?php echo urlencode($current_admin["id"]) ?>"
      onclick="return confirm('Are you sure?')">Delete admin</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
