<?php if (!isset($layout_content)) { $layout_content = "public"; } // LAYOUT CONTEXT ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/styles.css">
  <title>Widget Corp <?php if ($layout_content == "admin") echo "Admin"; ?></title>
</head>
<body>

  <div id="header">
    <h1>Widget Corp <?php if ($layout_content == "admin") echo "Admin"; ?></h1>
  </div>
