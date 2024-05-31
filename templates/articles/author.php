<?php

/**
 * Framework Title: Bolt Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 *
 */

use celionatti\Bolt\Helpers\Utils\StringUtils;

$token = generateToken();

?>

<?php $this->setTitle($title ?? "Author"); ?>

<?php $this->start('header') ?>
<style>
    :root {
        --bs-body-bg: transparent;
        /* Default background color */
    }
</style>
<?php $this->end() ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container animate-box">
        <div class="row">
            <div class="archive-header">
                <div class="post-author-info">
                    <img class="section_margin_20" src="<?= get_image("", "avatar") ?>" alt="author details" />
                    <div class="archive-title">
                        <h2>Ryan Mark</h2>
                    </div>
                    <p>Ouch oh alas crud unnecessary invaluable some goodness opposite hell and absurdly much boa</p>
                    <ul>
                        <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="container">
        <div class="primary margin-15">
            <div class="row">
                <div class="col-md-8">
                    <h3 class="section_margin">Articles written by Ryan Mark</h3>
                    <div class="post_list post_list_style_1">
                        <article class="row section_margin animate-box shadow border-bottom border-info border-1 py-2 px-1 me-1 rounded">
                            <div class="col-md-4 animate-box">
                                <figure class="alith_news_img shadow"><a href='/single'><img src="<?= get_image() ?>" alt="" class="img-fluid img-size" /></a></figure>
                            </div>
                            <div class="col-md-8 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam</a></h3>
                                <div class="post_meta">
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                                <p class="alith_post_except">Aliquet accumsan etiam pharetra quisque turpis et metus nullam suspendisse ultricies, eu tempus phasellus platea lectus maecenas lorem sagittis pretium </p>
                                <a class='read_more btn border border-2 border-dark px-3 py-2 mt-3' href="<?= URL_ROOT . "" ?>">Read More</a>
                            </div>
                        </article>

                        <div class="site-pagination animate-box">
                            <?= $pagination ?>
                        </div>
                    </div>
                </div>
                <!--Start Sidebar-->
                <?= partials("homepage-sidebar") ?>
                <!--End Sidebar-->
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?= partials("homepage-extra") ?>

<?php $this->end() ?>