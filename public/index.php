<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(true); ?>

<div id="main" class="row">

  <div class="side col-xs-3 menu">
		<?php echo public_navigation($current_subject, $current_page); ?>
  </div>

  <div id="page" class="col-xs-9">

      <?php echo message(); // Session Message (if any) ?>

      <?php
        if ($current_page) {
          echo "<h2 class=\"index\">" . htmlentities($current_page["menu_name"]) . "</h2>";
          echo "<div>";
          echo $current_page["content"];
          echo "</div>";

        } else {
          echo "<br />Welcome";
        }
      ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
