<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $current_admin = find_admin_by_id($_GET["id"]); // CHECK FOR ADMIN ID ?>
<?php if (!$current_admin) {redirect_to("manage_admins.php");} // REDIRECT IF SUBJECT NOT FOUND ?>
<?php update_admin($current_admin); // UPDATE ADMIN IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    &nbsp;
  </div>

  <div id="page" class="col-xs-12 col-md-8 col-md-offset-3">

    <?php if (!empty($message)) { echo "<div class=\"message\">" . htmlentities($message) . "</div>"; } // ERROR MESSAGE (IF ANY) ?>
    <?php echo form_errors($errors); // FORM ERRORS (IF ANY) ?>

    <h2>Edit Admin <?php echo htmlentities($current_admin["username"]); ?></h2>

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>

    <div class="row">
      <div class="col-xs-9">
        <fieldset>
          <form class="form-horizontal" action="edit_admin.php?id=<?php echo htmlentities($current_admin["id"]); ?>" method="post">

            <div class="form-group">
              <label for="inputUsername" class="col-md-2 control-label">Username</label>

              <div class="col-md-10">
                <input type="text" class="form-control" name="username" id="inputEmail" placeholder="Username" value="<?php echo htmlentities($current_admin["username"]); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword" class="col-md-2 control-label">Password</label>

              <div class="col-md-10">
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" value="">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-10 col-md-offset-2">
                <input class="btn btn-raised btn-success" type="submit" name="submit" value="Update admin">
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

    <a class="btn btn-raised btn-default" href="manage_admins.php">Cancel</a>
    &nbsp;
    &nbsp;
    <a class="btn btn-raised btn-danger" href="delete_admin.php?id=<?php echo urlencode($current_admin["id"]) ?>"
      onclick="return confirm('Are you sure?')">Delete admin</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
