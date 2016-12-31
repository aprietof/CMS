<?php if (!isset($layout_content)) { $layout_content = "public"; } // LAYOUT CONTEXT ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

  <title>Widget Corp <?php if ($layout_content == "admin") echo "Admin"; ?></title>
</head>
<body>

  <div id="header">
    <h1>Widget Corp <?php if ($layout_content == "admin") echo "Admin"; ?></h1>
  </div>
