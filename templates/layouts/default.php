<?php

use celionatti\Bolt\Helpers\FlashMessages\BootstrapFlashMessage;


?>

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>NattiNation Global | <?= $this->getTitle() ?></title>

    <!-- Bootstrap, Font Awesome, Aminate, Owl Carausel, Normalize CSS -->
    <link href="<?= get_stylesheet('bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('all.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('animate.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('owl.carousel.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('owl.theme.default.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('normalize.css" rel="stylesheet') ?>" type="text/css" />
    <link href="<?= get_stylesheet('slicknav.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Site CSS -->

    <link href="<?= get_stylesheet('main.css?v=2.0') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= get_stylesheet('responsive.css?v=2.0') ?>" rel="stylesheet" type="text/css" />

    <!-- Modernizr JS -->
    <script src="<?= get_script('modernizr-3.5.0.min.js') ?>"></script>

    <!--Favicon-->
    <link rel="shortcut icon" href="<?= get_image('assets/img/favicon.png', "icon") ?>" type="image/x-icon">
    <link rel="icon" href="<?= get_image('assets/img/favicon.png', "icon") ?>" type="image/x-icon">

    <meta property="og:title" content="NattiNation Global | NattiNation Global News" />
    <meta property="og:description" content="This is meta description" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="" />
    <meta property="og:updated_time" content="2020-03-15T15:40:24+06:00" />
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <?php $this->content('header') ?>
</head>

<body>

    <div id="wrapper">
        <?= partials("sidebar") ?>

        <div id="page-content-wrapper">
            <?= partials("header") ?>

            <?= partials("navbar") ?>

            <!-- Your Content goes in here. -->
            <?php $this->content('content'); ?>

            <?= partials("footer") ?>
        </div>
    </div>


    <!-- JavaScript Libraries -->
    <script src="<?= get_script('jquery-3.7.0.min.js'); ?>"></script>
    <!--  -->
    <script src="<?= get_script('owl.carousel.min.js'); ?>"></script>
    <script src="<?= get_script('jquery.waypoints.min.js'); ?>"></script>
    <script src="<?= get_script('jquery.slicknav.min.js'); ?>"></script>
    <script src="<?= get_script('masonry.pkgd.min.js'); ?>"></script>
    <script src="<?= get_script('jquery.sticky-sidebar.js'); ?>"></script>

    <!--Poprup-->
    <link href="assets/css/popup.css" rel="stylesheet">
    <script src="<?= get_script('jquery.bpopup.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#popup_this').bPopup();
        });
    </script>

    <!-- Main -->
    <script src="<?= get_script('main.js?v=2.0'); ?>"></script>
    <script src="<?= get_script('smart-sticky.js?v=2.0'); ?>"></script>

    <!-- Template Javascript -->
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