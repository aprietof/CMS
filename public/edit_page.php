<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>
<?php if (!$current_page) {redirect_to("manage_content.php");} // REDIRECT IF SUBJECT NOT FOUND ?>
<?php update_page($current_page); // UPDATE SUBJECT IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">

  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page">

    <?php if (!empty($message)) { echo "<div class=\"message\">" . htmlentities($message) . "</div>"; } // ERROR MESSAGE (IF ANY) ?>
    <?php echo form_errors($errors); // FORM ERRORS (IF ANY) ?>

    <h2>Edit Page <?php echo htmlentities($current_page["menu_name"]); ?></h2>

    <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>" method="post">

      <p>Menu Name:
        <input type="text"
               name="menu_name"
               value="<?php echo htmlentities($current_page["menu_name"]); ?>">
      </p>

      <p>Position:
        <select name="position">
          <?php
            $pages_count = pages_count($current_page["subject_id"]);
            for ($count=1; $count <= $pages_count; $count++) {
              echo "<option value=\"{$count}\"";
              if ($current_page["position"] == $count) {
                echo " selected";
              }
              echo ">{$count}</option>";
            }
          ?>
        </select>
      </p>

      <p>Visible:
        <input type="radio" name="visible" value="0"
        <?php if ($current_page["visible"] == 0) { echo " checked";} ?>>No
        &nbsp;
        <input type="radio" name="visible" value="1"
        <?php if ($current_page["visible"] == 1) { echo " checked";} ?>>Yes
      </p>

      <p>Content:</p>
      <textarea name="content" rows="14" cols="100"><?php echo $current_page["content"]; ?>
      </textarea><br />

      <br />
      <input type="submit" name="submit" value="Update Page">

    </form>
    <br />
    <a href="manage_content.php?page=<?php echo urlencode($current_page["id"]) ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]) ?>"
      onclick="return confirm('Are you sure?')">Delete Page</a>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
