<div id="footer">
  &copy; Copyright <?php echo date("Y"); ?>, Widget Corp
</div>

</body>
</html>

<?php if (isset($db)) { mysqli_close($db); } // CLOSE DB CONNECTION (IF ANY) ?>
