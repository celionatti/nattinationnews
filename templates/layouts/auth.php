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
    <!-- Bootstrap library -->
    <link type="text/css" rel="stylesheet" href="<?= get_bootstrap('css/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= get_bootstrap('css/bootstrap-icons.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?= get_package('toastr/toastr.min.css'); ?>">
    <title>Natti Quiz | Auth</title>
    <?php $this->content('header') ?>
</head>

<body>
    <?= BootstrapFlashMessage::alert(); ?>
    <!-- Your Content goes in here. -->
    <?php $this->content('content'); ?>

    <script src="<?= get_package('jquery/jquery-3.6.3.min.js'); ?>"></script>
    <script src="<?= get_package('toastr/toastr.min.js'); ?>"></script>
    <script src="<?= get_bootstrap('js/bootstrap.bundle.min.js'); ?>"></script>
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