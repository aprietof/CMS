<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>
<?php include("../includes/layouts/header.php"); // HEADER ?>

<?php
  // CHECK FOR PAGE CONTENT
  $selected_subject_id = NULL;
  $selected_page_id = NULL;

  if (isset($_GET["subject"])) {
    $selected_subject_id = $_GET["subject"];
  } elseif (isset($_GET["page"])) {
    $selected_page_id = $_GET["page"];
  }
?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($selected_subject_id, $selected_page_id); ?>
  </div>

  <div id="page">
    <h2>Manage Content</h2>

      <?php echo $selected_subject_id; ?>
      <?php echo $selected_page_id; ?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
