<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php $layout_content = "admin"; ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <h2>Admin Menu</h2>
    <p>Welcome to Admin area, <?php echo ucfirst(htmlentities($_SESSION["username"])); ?>.</p>
    <ul>
      <li><a href="manage_content.php">Manage Webasite Content</a></li>
      <li><a href="manage_admins.php">Manage Admin Users</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
