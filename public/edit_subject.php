<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>
<?php if (!$current_subject) {redirect_to("manage_content.php");} // REDIRECT IF SUBJECT NOT FOUND ?>
<?php update_subject($current_subject); // UPDATE SUBJECT IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>


<div id="main">

  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page">

    <?php if (!empty($message)) { echo "<div class=\"message\">" . htmlentities($message) . "</div>"; } // ERROR MESSAGE (IF ANY) ?>
    <?php echo form_errors($errors); // FORM ERRORS (IF ANY) ?>

    <h2>Edit Subject <?php echo htmlentities($current_subject["menu_name"]); ?></h2>

    <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">

      <p>Menu Name:
        <input type="text"
               name="menu_name"
               value="<?php echo htmlentities($current_subject["menu_name"]); ?>">
      </p>

      <p>Position:
        <select name="position">
          <?php
            $subject_count = subjects_count();
            for ($count=1; $count <= $subject_count; $count++) {
              echo "<option value=\"{$count}\"";
              if ($current_subject["position"] == $count) {
                echo " selected";
              }
              echo ">{$count}</option>";
            }
          ?>
        </select>
      </p>

      <p>Visible:
        <input type="radio" name="visible" value="0"
        <?php if ($current_subject["visible"] == 0) { echo " checked";} ?>>No
        &nbsp;
        <input type="radio" name="visible" value="1"
        <?php if ($current_subject["visible"] == 1) { echo " checked";} ?>>Yes
      </p>

      <input type="submit" name="submit" value="Update Subject">

    </form>
    <br />
    <a href="manage_content.php">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]) ?>"
      onclick="return confirm('Are you sure?')">Delete subject</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
