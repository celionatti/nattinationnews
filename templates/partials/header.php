<?php


/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */


use celionatti\Bolt\Authentication\BoltAuthentication;


$currentUser = BoltAuthentication::currentUser();


?>

<?php if (!is_null($currentUser)) : ?>
    <div class="container-fluid bg-dark text-white mb-1">
        <div class="container">
            <div class="top_bar margin-15">
                <div class="row">
                    <div class="col-md-6 col-sm-12 time">
                        <i class="fa-regular fa-user mx-1"></i><span>Hi,&nbsp;<?= $currentUser->surname ?></span>
                    </div>
                    <div class="col-md-6 col-sm-12 social">
                        <ul>
                            <li><a href="<?= URL_ROOT . "admin" ?>" class="text-white"><i class="fa-solid fa-gauge text-white"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="container-fluid">
    <div class="container">
        <div class="top_bar margin-15">
            <div class="row">
                <div class="col-md-6 col-sm-12 time">
                    <div class="off-canvas-toggle" id="off-canvas-toggle"><span></span>
                        <p class="sidebar-open">MORE</p>
                    </div>
                    <i class="fa-regular fa-clock"></i><span>&nbsp;&nbsp;&nbsp;<?= date("l, j M Y") ?></span>
                </div>
                <div class="col-md-6 col-sm-12 social">
                    <ul>
                        <?php if (setting("facebook_link")) : ?>
                            <li><a href="<?= setting("facebook_link") ?>"><i class="fa-brands fa-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (setting("x_link")) : ?>
                            <li><a href="<?= setting("x_link") ?>"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (setting("youtube_link")) : ?>
                            <li><a href="<?= setting("youtube_link") ?>"><i class="fa-brands fa-youtube"></i></a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="top-search">
                        <i class="fa fa-search"></i><span>SEARCH</span>
                    </div>
                    <div class="top-search-form">
                        <form action="<?= URL_ROOT . "search" ?>" class="search-form" method="get" role="search">
                            <label>
                                <span class="screen-reader-text">Search for:</span>
                                <input type="search" name="search" value="" placeholder="Search …" class="search-field">
                            </label>
                            <input type="submit" value="Search" class="search-submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 header">
                <h1 class="logo logo-script"><a href="<?= URL_ROOT ?>"><?= htmlspecialchars_decode(setting("site_name", '<span class="text-success">N</span>ATTI <span class="text-success">N</span>ATION')) ?></a></h1>
                <p class="tagline"><?= htmlspecialchars_decode(setting("tagline")) ?></p>
            </div>
        </div>
    </div>
</div>