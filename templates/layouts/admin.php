<?php

use celionatti\Bolt\Helpers\FlashMessages\BootstrapFlashMessage;


?>

<!DOCTYPE html>
<html lang="en_US" data-bs-theme="auto">

<head>
    <script src="<?= get_script('color-modes.js') ?>"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" width="32" href="<?= get_image('assets/img/favicon.png', "icon") ?>" />
    <link rel="apple-touch-icon" width="32" href="<?= get_image('assets/img/favicon.png', "icon") ?>" />

    <link type="text/css" rel="stylesheet" href="<?= get_stylesheet('admin.css'); ?>">
    <!-- Bootstrap library -->
    <link type="text/css" rel="stylesheet" href="<?= get_bootstrap('css/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= get_bootstrap('css/bootstrap-icons.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= get_package('toastr/toastr.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= get_package('datatables/datatables.min.css'); ?>">
    <title>NattiQ | Admin Dashboard</title>
    <?php $this->content('header') ?>
</head>

<body class="sb-nav-fixed">
    <?= BootstrapFlashMessage::alert(); ?>
    <?= partials("admin-header") ?>
    <div id="layoutSidenav">
        <?= partials("admin-sidebar") ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Your Content goes in here. -->
                    <?php $this->content('content'); ?>
                </div>
            </main>
            <?= partials("admin-footer") ?>
        </div>
    </div>

    <script src="<?= get_script('jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?= get_package('toastr/toastr.min.js'); ?>"></script>
    <script src="<?= get_script('admin.js'); ?>"></script>
    <script src="<?= get_bootstrap('js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= get_package('datatables/datatables.min.js'); ?>"></script>
    <script>
        function redirectToLink(link) {
            // Use window.location.href to redirect to the specified link
            // window.location.href = link;
            window.open('/' + '/' + link, '_blank');
        }

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        <?php if (isset($_SESSION['__flash_toastr'])) : ?>
            <?php
            $toastr = $_SESSION['__flash_toastr'];
            unset($_SESSION['__flash_toastr']); // Remove the toastr from the session
            ?>
            toastr.<?= $toastr['type'] ?>("<?= $toastr['message'] ?>");
        <?php endif; ?>
    </script>
    <?php $this->content('script') ?>
</body>

</html>