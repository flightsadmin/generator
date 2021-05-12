<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codeigniter 4</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="<?php echo base_url('css/app.css');?>" rel="stylesheet">
</head>

<body>
    <!-- Header -->
     <?= $this->include('layouts/header') ?>


<div class="container-fluid">
  <div class="row">
        <!-- Sidebar -->
        <?= $this->include('layouts/sidebar') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?= $this->renderSection('content') ?>
    </main>
  </div>
</div>
  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url('js/app.js');?>"></script>
</body>
</html>