<?php require_once("../includes/session.php"); // START SESSION AND SESSION FUNCTIONS ?>
<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>
<?php find_selected_page(); // CHECK FOR PAGE CONTENT ?>

<div id="main">

  <div id="navigation">
    <br />
    <a href="admin.php">&laquo; Main Menu</a><br />
    <?php echo navigation($current_subject, $current_page); ?>
    <br />
    <a href="new_subject.php">+ Add a subject</a>
  </div>

  <div id="page">


    <?php echo message(); // Session Message (if any) ?>

    <?php
      if ($current_subject) {
        echo "<h2>Manage Content</h2>";
        echo "Menu Name: " . htmlentities($current_subject["menu_name"]) . "<br/>";
        echo "Position: {$current_subject["position"]} <br/>";
        echo "Visible: ";
        echo $current_subject["visible"] == 1 ? "Yes <br/>" : "No <br/>";
        echo "<br/>";
        echo "<a href=\"edit_subject.php?subject=" . urlencode($current_subject["id"]) . "\" >Edit Subject</a>";
      } elseif ($current_page) {
        echo "<h2>Manage Page</h2>";
        echo "Page Name: " . htmlentities($current_page["menu_name"]) . "<br/>";
        echo "Position: {$current_page["position"]} <br/>";
        echo "Visible: ";
        echo $current_page["visible"] == 1 ? "Yes <br/>" : "No <br/>";
        echo "Content: ";
        echo "<div class=\"view-content\">";
        echo htmlentities($current_page["content"]);
        echo "</div>";
        echo "<br/>";
        echo "<a href=\"edit_page.php?page={$current_page["id"]}\" >Edit Page</a>";
      } else {
        echo "<br />Please select a subject or a page";
      }
    ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
