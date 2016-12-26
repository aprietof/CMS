<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>
<?php require_once("../includes/functions.php"); // FUNCTIONS FILE ?>

<?php
  // PERFORM SUBJECTS DB QUERY
  $query = "SELECT * FROM subjects WHERE visible = 1";
  $result = mysqli_query($db, $query); #=> collection of database rows

  // Test if there was a query error
  confirm_query($result);
?>

<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">
  <div id="navigation">

    <ul class="subjects">
      <?php
        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($result)) { // increment the pointer
          // output data from each row
          echo "<li>{$subject["menu_name"]}";

          // PERFORM PAGES DB QUERY
          $query = "SELECT * FROM pages WHERE visible = 1 AND subject_id = {$subject["id"]} ORDER BY position ASC";
          $page_set = mysqli_query($db, $query); #=> collection of database rows

          // Test if there was a query error
          confirm_query($page_set);
          echo "<ul class='pages'>";

          while ($page = mysqli_fetch_assoc($page_set)) { // increment the pointer
            // output data from each row
            echo "<li>{$page["menu_name"]}</li>";
          }

          mysqli_free_result($page_set); // RELEASE PAGES RETURNED DB

          echo "</ul>";
          echo "</li>";
        }
      ?>
      <?php mysqli_free_result($result); // RELEASE RETURNED DB ?>
    </ul>

  </div>
  <div id="page">
    <h2>Manage Content</h2>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); // FOOTER ?>
