<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>

  <div id="page">

    <?php
      if ($current_subject) {
        echo "<h2>Manage Content</h2>";
        echo "Menu Name: {$current_subject["menu_name"]}<br/>";
      } elseif ($current_page) {
        echo "<h2>Manage Page</h2>";
        echo "Page Name: {$current_page["menu_name"]}<br/>";
      } else {
        echo "Please select a subject or a page";
      }
    ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
