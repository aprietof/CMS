<?php if (!isset($layout_content)) { $layout_content = "public"; } // LAYOUT CONTEXT ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Material Design fonts -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- Bootstrap Javascript -->
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Material Javascript  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.8/js/tether.min.js"></script>
  <script src="node_modules/bootstrap-material-design/dist/js/material.min.js"></script>
  <script src="node_modules/bootstrap-material-design/dist/js/ripples.min.js"></script>
  <script src="node_modules/snackbarjs/dist/snackbar.min.js"></script>

  <!-- Bootstrap & Material Bootstrap Stylesheets -->
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.8/css/tether.css" rel="stylesheet" />
  <link href="node_modules/snackbarjs/dist/snackbar.min.css" rel="stylesheet" />
  <link href="node_modules/bootstrap-material-design/dist/css/bootstrap-material-design.min.css" rel="stylesheet" />
  <link href="node_modules/bootstrap-material-design/dist/css/ripples.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/styles.css">

  <?php // ONLY LOAD TEXT EDITOR IF ADMIN
  if($layout_context = "admin") { ?>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script>
    tinymce.init({
      selector: '#mytextarea',
      theme: 'modern',
      width: 600,
      height: 250,
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table contextmenu directionality emoticons template paste textcolor'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons'
    });
    </script>
  <?php }?>

  <title>CMS <?php if ($layout_content == "admin") echo "Admin"; ?></title>
</head>
<body>

  <div class="navbar <?php if($layout_content == "admin") echo "navbar-info" ;?>">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php" ><i class="material-icons">store</i> Company Name <?php if ($layout_content == "admin") echo "Admin"; ?></a>

      <?php if(logged_in() && $layout_content == "admin") { ?>

        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php">Logout <i class="material-icons">power_settings_new</i></a></li>
        </ul>

      <?php } ?>
    </div>
  </div>
