<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $admin_set = find_all_admins(); // FIN ALL ADMINS IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    <br />
    <a href="admin.php">&laquo; Main Menu</a><br />
  </div>

  <div id="page">

    <?php echo message(); // Session Message (if any) ?>
    <h2>Manage Admins</h2>

    <table>
      <tr>
        <th class="username">Username</th>
        <th class="actions">Actions</th>
      </tr>

      <?php while ($admin = mysqli_fetch_assoc($admin_set)) { ?>
        <tr>
          <td><?php echo htmlentities($admin["username"]); ?></td>
          <td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></td>
          <td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>"
            onclick="return confirm('Are you sure?')">Delete</a></td>
        </tr>
      <?php } ?>
    </table>
    <br />
    + <a href="new_admin.php">Add new admin</a> &nbsp; <a href="manage_content.php">Cancel</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
