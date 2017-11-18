<?php use Core\Helpers; ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>DMP</title>
        <base href="<?php echo BASE_PATH; ?>">
        <link rel="stylesheet" href="<?php echo Helpers::asset('css/style.css'); ?>">
        <script src="<?php echo Helpers::asset('js/jquery.min.js'); ?>"></script>
        <script src="<?php echo Helpers::asset('js/script.js'); ?>"></script>
    </head>

    <body>
        <div id="wrapper">
            <header id="header">
                <h1 class="text-center">DMP</h1>
                <h2 class="text-center">Data Management Platform</h2>
                <div class="text-center">
                    <a href="<?php echo Helpers::path('description.pdf'); ?>"  class="docs" title="Documentation" target="_blank">Description</a>
                    <br/>
                    <a href="https://github.com/maksimgru/dmp" class="download" title="Fork me on GitHub" target="_blank">Fork me on GitHub</a>
                </div>
                <nav id="top-nav">
                    <ul class="main-menu fl">
                        <li><a href="<?php echo Helpers::path(); ?>" class="<?php echo Helpers::isCurrentURI() ? 'active' : ''; ?>">Home</a></li>
                        <li><a href="<?php echo Helpers::path('users/table'); ?>" class="<?php echo Helpers::isCurrentURI('users/table') ? 'active' : ''; ?>">Users Table</a></li>
                        <li><a href="<?php echo Helpers::path('users/add'); ?>" class="<?php echo Helpers::isCurrentURI('users/add') ? 'active' : ''; ?>">Add New User</a></li>
                    </ul>
                </nav>
            </header><!-- #header-->

            <section id="content">