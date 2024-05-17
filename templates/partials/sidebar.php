<?php


/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */


use celionatti\Bolt\Helpers\Utils\StringUtils;
use PhpStrike\models\Articles;

$articles = new Articles();

$trends = $articles->getTrendingArticles();

$token = currentTime();

?>

<div id="sidebar-wrapper">
    <div class="sidebar-inner">
        <div class="off-canvas-close"><span>CLOSE</span></div>
        <div class="sidebar-widget">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Popular Articles</span></h4>
            </div>
            <ul class="menu" id="sidebar-menu">
                <?= sidebarNav(); ?>
                <li class="menu-item"><a href="<?= URL_ROOT . "contact" ?>">Contact</a></li>
            </ul>
        </div>

        <div class="sidebar-widget">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Trending</span></h4>
            </div>
            <div class="latest_style_2">
                <?php if ($trends) : ?>
                    <?php if ($trends[0]) : ?>
                        <div class="latest_style_2_item_first">
                            <figure class="alith_post_thumb_big">
                                <span class="post_meta_categories_label">Legal, Blog</span>
                                <a href="<?= URL_ROOT . "article/{$trends[0]->article_id}/{$token}" ?>"><img src="<?= get_image($trends[0]->thumbnail) ?>" alt="<?= $trends[0]->thumbnail_caption ?>" style="width:100%;" class="img-fluid" /></a>
                            </figure>
                            <h4 class="alith_post_title">
                                <a href="<?= URL_ROOT . "article/{$trends[0]->article_id}/{$token}" ?>"><strong><?= $trends[0]->title ?></strong></a>
                            </h4>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($trends as $i => $trend) : ?>
                        <?php if ($i !== 0) : ?>
                            <div class="latest_style_2_item">
                                <figure class="alith_news_img"><a href="<?= URL_ROOT . "article/{$trend->article_id}/{$token}" ?>"><img src="<?= get_image($trend->thumbnail) ?>" alt="<?= $trend->thumbnail_caption ?>" /></a></figure>
                                <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$trend->article_id}/{$token}" ?>"><?= $trend->title ?></a></h3>
                                <div class="post_meta">
                                    <span class="meta_date"><?= date("d M, Y", strtotime($trend->created_at)) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div> <!--.sidebar-widget-->

        <div class="sidebar-widget">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Advertise</span></h4>
            </div>
            <div class="banner-adv">
                <div class="adv-thumb">
                    <a href="#">
                        <img class="aligncenter" alt="img1" src="<?= get_image("assets/img/ads-online.png") ?>">
                    </a>
                </div>
            </div>
        </div> <!--.sidebar-widget-->
    </div>
</div> <!--#sidebar-wrapper-->