<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $admin_set = find_all_admins(); // FIN ALL ADMINS IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main" class="row">

  <div id="page" class="col-xs-12 col-msm-8 col-sm-offset-2 col-md-8 col-md-offset-3">
    <br />
    <?php echo message(); // Session Message (if any) ?>
    <h1>Manage Admins</h1><br />

    <div class="row">
      <div class="col-xs-8">
        <table class="table table-striped table-hover">
          <tr>
            <th class="username">Username</th>
            <th class="actions">Actions</th>
            <th class="actions"></th>
          </tr>

          <?php while ($admin = mysqli_fetch_assoc($admin_set)) { ?>
            <tr>
              <td><h4><?php echo htmlentities($admin["username"]); ?></h4></td>
              <td><a class="btn btn-raised btn-primary btn-sm" href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>"><i class="material-icons small">edit</i> Edit</a></td>
              <td><a class="btn btn-raised btn-danger btn-sm" href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>"
                onclick="return confirm('Are you sure?')"><i class="material-icons small">delete</i> Delete</a></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
    <br />
    <a class="btn btn-raised btn-warning" href="new_admin.php">Add new admin</a> &nbsp; <a class="btn btn-raised" href="manage_content.php">Cancel</a>
    <br />
    <a class="btn btn-raised btn-default btn-sm" href="admin.php">&laquo; Main Menu</a><br />

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
