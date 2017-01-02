<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php $layout_content = "admin"; ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div class="col-xs-12 col-msm-6 col-sm-offset-3 col-md-6 col-md-offset-3">
    <div class="jumbotron">
      <div id="page">
        <h1>Admin Menu</h1>
        <p>Welcome to Admin area, <?php echo ucfirst(htmlentities($_SESSION["username"])); ?>.</p>
        <ul>
          <li><h3><a href="manage_content.php">Manage Website Content</a></h3></li>
          <li><h3><a href="manage_admins.php">Manage Admin Users</a></h3></li>
          <li><h3><a href="logout.php">Logout</a></h3></li>
        </ul>
      </div>
    </div>
  </div>

</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
