<div id="footer">
  &copy; Copyright <?php echo date("Y"); ?>, Adrian Prieto
</div>

  <!-- Javascript -->
  <script src="js/index.js"></script>
</body>
</html>

<?php if (isset($db)) { mysqli_close($db); } // CLOSE DB CONNECTION (IF ANY) ?>
