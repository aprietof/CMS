<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    &nbsp;
  </div>

  <div id="page" class="col-xs-12 col-md-8 col-md-offset-3">

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>
    <h2>Create Admin</h2>

    <div class="row">
      <div class="col-xs-9">

        <form class="form-horizontal" action="create_admin.php" method="post">
          <fieldset>
            <div class="form-group">
              <label for="inputUsername" class="col-md-2 control-label">Username</label>

              <div class="col-md-10">
                <input type="text" class="form-control" name="username" id="inputEmail" placeholder="Username" value="">
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

                <input class="btn btn-raised btn-success" type="submit" name="submit" value="Create admin">

              </div>
            </div>

          </fieldset>
        </form>
      </div>
    </div> <!-- end form row -->

    <a href="manage_admins.php">&laquo; Back to Manage Admins</a><br />
    <br />
    <a href="admin.php">&laquo; Main Menu</a><br />

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
