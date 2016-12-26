<?php require_once("../includes/db_connection.php"); // CREATE DB CONNECTION ?>

<?php
  // PERFORM DB QUERY
  $query = "SELECT * FROM subjects WHERE visible = 1";
  $result = mysqli_query($db, $query); #=> collection of database rows

  // Test if there was a query error
  if(!$result) {
    die("Database query failed.");
  }
?>

<?php include("../includes/layouts/header.php"); // HEADER ?>

<div id="main">
  <div id="navigation">

    <ul class="subjects">
      <?php
        // USE RETURNED DATA (IF ANY)
        while ($subject = mysqli_fetch_assoc($result)) { // increment the pointer
          // output data from each row
          echo "<li>{$subject["menu_name"]} - ({$subject["id"]})</li>";
        }
      ?>
    </ul>

  </div>
  <div id="page">
    <h2>Manage Content</h2>

  </div>
</div>

<?php mysqli_free_result($result); // RELEASE RETURNED DB ?>
<?php include("../includes/layouts/footer.php"); // FOOTER ?>
