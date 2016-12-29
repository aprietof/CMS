<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); ?>

<div id="main">

  <div id="navigation">
		<?php echo public_navigation($current_subject, $current_page); ?>
  </div>

  <div id="page">

    <?php echo message(); // Session Message (if any) ?>

    <?php
      if ($current_subject) {
        echo "<h2>Manage Content</h2>";
        echo "Menu Name: " . htmlentities($current_subject["menu_name"]) . "<br/>";


      } elseif ($current_page) {
        echo "<h2>Manage Page</h2>";
        echo "Page Name: " . htmlentities($current_page["menu_name"]) . "<br/>";
        echo "<div class=\"view-content\">";
        echo htmlentities($current_page["content"]);
        echo "</div>";

      } else {
        echo "<br />Welcome";
      }
    ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
