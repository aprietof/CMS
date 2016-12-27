<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>

<div id="main">

  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
    <br />
    <a href="new_subject.php">+ Add a subject</a>
  </div>

  <div id="page">


    <?php echo message(); // Session Message (if any) ?>

    <?php
      if ($current_subject) {
        echo "<h2>Manage Content</h2>";
        echo "Menu Name: {$current_subject["menu_name"]}<br/>";
        echo "<a href=\"edit_subject.php?subject={$current_subject["id"]}\" >Edit Subject</a>";
      } elseif ($current_page) {
        echo "<h2>Manage Page</h2>";
        echo "Page Name: {$current_page["menu_name"]}<br/>";
        echo "<a href=\"edit_page.php?page={$current_page["id"]}\" >Edit Page</a>";
      } else {
        echo "Please select a subject or a page";
      }
    ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
