<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php login(); ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>

    <h2>Login</h2>

    <form action="login.php" method="post">

      <p>
        Username: <br />
        <input type="text" name="username"
        value=<?php echo htmlentities($username); // global $username from function ?>>
      </p>

      <p>
        Password: <br />
        <input type="password" name="password" value="">
      </p>

      <input type="submit" name="submit" value="Submit">

    </form>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
