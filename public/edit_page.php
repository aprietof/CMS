<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php require_once("../includes/validation_functions.php"); // VALIDATION FUNCTIONS FILE ?>
<?php redirect_if_not_logged_in(); // REDIRECT TO LOGIN PAGE IF NOT LOGGED IN ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>
<?php if (!$current_page) {redirect_to("manage_content.php");} // REDIRECT IF SUBJECT NOT FOUND ?>
<?php update_page($current_page); // UPDATE SUBJECT IN DATABASE ?>
<?php $layout_content = "admin"; // ADMIN LAYOUT CONTEXT ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main" class="row">

  <div class="side col-xs-3 menu">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page" class="col-xs-9">

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
          <?php if ($current_page["visible"] == 0) { echo " checked";} ?>> No
          &nbsp;
          <input type="radio" name="visible" value="1"
          <?php if ($current_page["visible"] == 1) { echo " checked";} ?>> Yes
        </p><br />

        <textarea id="mytextarea" name="content" rows="14" cols="100"><?php echo $current_page["content"]; ?>
        </textarea><br />

        <input class="btn btn-raised btn-success" type="submit" name="submit" value="Update Page">

      </form>

      <a class="btn btn-raised btn-default" href="manage_content.php?page=<?php echo urlencode($current_page["id"]) ?>">Cancel</a>
      &nbsp;
      &nbsp;
      <a class="btn btn-raised btn-danger" href="delete_page.php?page=<?php echo urlencode($current_page["id"]) ?>"
        onclick="return confirm('Are you sure?')"><i class="material-icons">delete</i> Delete Page</a><br />
        <br />

  </div>

</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
