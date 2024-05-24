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

<?php $this->setTitle($title ?? "Region"); ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container animate-box">
        <div class="row">
            <div class="archive-header">
                <div class="archive-title">
                    <h2><?= $regionDetails->region ?></h2>
                </div>
                <div class="archive-description">
                    <p><?= htmlspecialchars_decode(nl2br($regionDetails->region_info)) ?></p>
                </div>
                <div class="bread">
                    <ul class="breadcrumbs" id="breadcrumbs">
                        <li class="item-home"><a class='bread-link bread-home' href="<?= URL_ROOT ?>" title='Home'>Home</a></li>
                        <li class="separator separator-home"> /</li>
                        <li class="item-current item-cat"><strong class="bread-current bread-cat"><?= $regionDetails->region ?></strong></li>
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
                    <div class="post_list grid-blance">
                        <div class="row">
                            <?php if ($regions) : ?>
                                <?php foreach ($regions as $region) : ?>
                                    <article class="col-md-6 animate-box section_margin">
                                        <div class="wrap">
                                            <figure class="alith_news_img">
                                                <span class="post_meta_categories_label">Politics</span>
                                                <a href="<?= URL_ROOT . "article/{$region->article_id}/{$token}" ?>"><img src="<?= get_image($region->thumbnail) ?>" alt="<?= $region->thumbnail_caption ?>" class="img-fluid w-100 rounded-2" style="height:357px;object-fit:cover;" /></a>
                                            </figure>
                                        </div>
                                        <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$region->article_id}/{$token}" ?>"><?= $region->title ?></a></h3>
                                        <div class="post_meta">
                                            <a class='meta_author_avatar' href="<?= URL_ROOT . "author/{$region->user_id}" ?>"><img src="<?= get_image("", "avatar") ?>" alt="author details" /></a>
                                            <span class="meta_author_name"><a class='author' href="<?= URL_ROOT . "author/{$region->user_id}" ?>">Steven Job</a></span>
                                            <span class="meta_date"><?= date("d M, Y", strtotime($region->created_at)) ?></span>
                                        </div>
                                        <p class="alith_post_except"><?= StringUtils::excerpt(htmlspecialchars_decode(nl2br($region->content)), 350) ?></p>
                                        <div class="line-space"></div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <h4 class="border-bottom border-2 py-2 px-4">No Region Article Found!</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="site-pagination animate-box">
                        <?= $pagination ?>
                    </div>
                </div>
                <!--Start Sidebar-->
                <?= partials("homepage-sidebar") ?>
                <!--End Sidebar-->
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end() ?>