<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">

    <?php echo message(); // Session Message (if any) ?>
    <h2>Create Admin</h2>

    <form action="create_admin.php" method="post">

      <p>
        Username: <br />
        <input type="text" name="username" value="">
      </p>

      <p>
        Password: <br />
        <input type="password" name="password" value="">
      </p>

      <input type="submit" name="submit" value="Create admin">

    </form>

    <a href="manage_admins.php">Cancel</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
