<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>
<?php if (!isset($current_subject)) { redirect_to("manage_content.php"); } // REDIRECT IF NOT ASSOCIATED TO A SUBJECT ?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page">

    <?php echo message(); // Session Message (if any) ?>
    <?php echo form_errors(errors()); // Session errors (if any) ?>
    <?php $subject_id = $current_subject["id"]; ?>

    <h2>Create Page</h2>

    <form action="create_page.php?subject=<?php echo $subject_id ?>" method="post">

      <p>Menu Name:
        <input type="text" name="menu_name" value="">
      </p>

      <p>Position:
        <select name="position">
          <?php
            $pages_count = pages_count($subject_id);
            for ($count=1; $count <= $pages_count + 1 ; $count++) {
              echo "<option value=\"{$count}\">{$count}</option>";
            }
          ?>
        </select>
      </p>

      <p>Visible:
        <input type="radio" name="visible" value="0">No
        &nbsp;
        <input type="radio" name="visible" value="1">Yes
      </p>

      <p>Content:</p>
      <textarea id="mytextarea" name="content" rows="14" cols="100"></textarea><br />

      <br />
      <input type="submit" name="submit" value="Create Page">

    </form>
    <br />
    <a href="manage_content.php?subject=<?php echo $current_subject["id"]; ?>">Cancel</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
