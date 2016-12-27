<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php
  // PERFORM SUBJECTS DB QUERY
  $subjects_set = find_all_subjects();
  confirm_query($subjects_set);
?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<?php
  // CHECK FOR PAGE CONTENT
  $selected_subject = NULL;
  $selected_page = NULL;

  if (isset($_GET["subject"])) {
    $selected_subject = $_GET["subject"];
  } elseif (isset($_GET["page"])) {
    $selected_page = $_GET["page"];
  }
?>

<div id="main">
  <div id="navigation">

    <ul class="subjects">
      <?php
        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($subjects_set)) { // increment the pointer
          // output data from each row
          echo "<li><a href=\"manage_content.php?subject=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a>";

          // PERFORM PAGES DB QUERY
          $pages_set = find_all_pages($subject["id"]);
          confirm_query($pages_set);

          echo "<ul class=\"pages\">";

          while ($page = mysqli_fetch_assoc($pages_set)) { // increment the pointer
            // output data from each row
            echo "<li><a href=\"manage_content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</a></li>";
          }

          mysqli_free_result($pages_set); // RELEASE PAGES RETURNED DB

          echo "</ul>";
          echo "</li>";
        }
      ?>
      <?php mysqli_free_result($subjects_set); // RELEASE RETURNED DB ?>
    </ul>

  </div>
  <div id="page">
    <h2>Manage Content</h2>

      <?php echo $selected_subject; ?>
      <?php echo $selected_page; ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
