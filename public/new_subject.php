<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>

<div id="main" class="row">

  <div class="side col-xs-3 menu">
    <a class="btn btn-raised btn-sm" href="admin.php">&laquo; Main Menu</a><br />
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page" class="col-xs-9">

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>

    <h2>Create Subject</h2>

    <form action="create_subject.php" method="post">

      <p>Menu Name:
        <input type="text" name="menu_name" value="">
      </p>

      <p>Position:
        <select name="position">
          <?php
            $subject_count = subjects_count();
            for ($count=1; $count <= $subject_count + 1 ; $count++) {
              echo "<option value=\"{$count}\">{$count}</option>";
            }
          ?>
        </select>
      </p>

      <p>Visible:
        <input type="radio" name="visible" value="0"> No
        &nbsp;
        <input type="radio" name="visible" value="1"> Yes
      </p>

      <input class="btn btn-raised btn-success" type="submit" name="submit" value="Create Subject">

    </form>
    <br />
    <a class="btn btn-raised btn-duefault" href="manage_content.php">Cancel</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
