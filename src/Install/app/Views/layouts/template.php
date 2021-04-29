<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Codeigniter</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo base_url('css/app.css');?>" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Header -->
         <?= $this->include('layouts/header') ?>

        <!-- Sidebar -->
        <?= $this->include('layouts/sidebar') ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content">
                    <?= $this->renderSection('content') ?>
                </section>
            </div>
        <?= $this->include('layouts/footer') ?>
    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url('js/app.js');?>" defer></script>
</body>
</html>
