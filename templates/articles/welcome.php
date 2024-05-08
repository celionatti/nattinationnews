<?php

/**
 * Framework Title: Bolt Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */

use celionatti\Bolt\Helpers\Utils\StringUtils;

$token = currentTime();

?>

<?php $this->setTitle($title ?? "Home"); ?>

<?php $this->start('content') ?>

<?php if ($editorsPick) : ?>
    <div class="container-fluid">
        <div class="container animate-box">
            <div class="row">
                <div class="owl-carousel owl-theme js carausel_slider section_margin" id="slider-small">
                    <?php foreach ($editorsPick as $pick) : ?>
                        <div class="item px-2">
                            <div class="alith_latest_trading_img_position_relative">
                                <figure class="alith_post_thumb">
                                    <a href="#"><img src="<?= get_image($pick->thumbnail) ?>" alt="<?= $pick->thumbnail_caption ?>" class="img-fluid" /></a>
                                </figure>
                                <div class="alith_post_title_small">
                                    <a href="<?= URL_ROOT . "article/{$pick->article_id}/{$token}" ?>"><strong><?= htmlspecialchars_decode(nl2br($pick->title)) ?></strong></a>
                                    <p class="meta"><span><?= date("d M, Y", strtotime($pick->created_at)) ?></span> <span><?= $pick->views ?> views</span></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="container">
        <div class="primary margin-15">
            <div class="row">
                <div class="col-md-8">
                    <div class="owl-carousel owl-theme js section_margin line_hoz animate-box" id="slideshow_face">
                        <?php if ($featuredArticles) : ?>
                            <?php foreach ($featuredArticles as $featured) : ?>
                                <div class="item">
                                    <figure class="alith_post_thumb_big">
                                        <span class="post_meta_categories_label">Legal, Blog</span>
                                        <a href="<?= URL_ROOT . "article/{$featured->article_id}/{$token}" ?>"><img src="<?= get_image($featured->thumbnail) ?>" alt="<?= $featured->thumbnail_caption ?>" class="img-fluid w-100 rounded-2" style="height:457px;object-fit:cover;" /></a>
                                    </figure>
                                    <h3 class="alith_post_title animate-box" data-animate-effect="fadeInUp">
                                        <a href="<?= URL_ROOT . "article/{$featured->article_id}/{$token}" ?>"><?= htmlspecialchars_decode(nl2br($featured->title)) ?></a>
                                    </h3>
                                    <div class="alith_post_content_big">
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="post_meta_center animate-box">
                                                    <p><a href="<?= URL_ROOT . "author/{$featured->user_id}" ?>"><img src="<?= get_image('', 'avatar') ?>" alt="author details" style="width:60px;" /></a></p>
                                                    <p><a class='author' href="<?= URL_ROOT . "author/{$featured->user_id}" ?>"><strong>Steven Job</strong></a></p>
                                                    <span class="post_meta_date"><?= date("d M, Y", strtotime($featured->created_at)) ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-12 animate-box">
                                                <p class="alith_post_except"><?= StringUtils::excerpt(htmlspecialchars_decode(nl2br($featured->content)), 350) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="post_list post_list_style_1">
                        <div class="alith_heading">
                            <h2 class="alith_heading_patern_2">Recent Posts</h2>
                        </div>

                        <?php if ($recentArticles) : ?>
                            <?php foreach ($recentArticles as $recentArticle) : ?>
                                <article class="row section_margin animate-box">
                                    <div class="col-md-3 animate-box">
                                        <figure class="alith_news_img"><a href='/single'><img src="<?= get_image($recentArticle->thumbnail) ?>" alt="<?= $recentArticle->thumbnail_caption ?>" /></a></figure>
                                    </div>
                                    <div class="col-md-9 animate-box">
                                        <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$recentArticle->article_id}/{$token}" ?>"><?= $recentArticle->title ?></a></h3>
                                        <div class="post_meta">
                                            <a class='meta_author_avatar' href="<?= URL_ROOT . "author/{$recentArticle->user_id}" ?>"><img src="<?= get_image('', 'avatar') ?>" alt="<?= getCombinedData(getArticleUser($recentArticle->user_id), "surname", "name") ?>" /></a>
                                            <span class="meta_author_name"><a class='author' href="<?= URL_ROOT . "author/{$recentArticle->user_id}" ?>"><?= getCombinedData(getArticleUser($recentArticle->user_id), "surname", "name") ?></a></span>
                                            <span class="meta_categories"><?= displayTags($recentArticle->tags) ?></span>
                                            <span class="meta_date"><?= date("d M, Y", strtotime($recentArticle->created_at)) ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <h4>No Record Found!</h4>
                                <a href="<?= URL_ROOT ?>"><i class="fa-solid fa-home"></i> Back to Home</a>
                            </div>
                        <?php endif; ?>

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