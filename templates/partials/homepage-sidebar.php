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

$popularArticles = $articles->getPopularArticles(5);
$trends = $articles->getTrendingArticles();

$tags = $articles->getArticleTags();
$uniqueWords = extractUniqueWords($tags);

$token = generateToken();

?>

<aside class="col-md-4">
    <div class="sidebar_right">
        <div class="sidebar-widget animate-box">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Popular Articles</span></h4>
            </div>
            <div class="latest_style_1">
                <?php if ($popularArticles) : ?>
                    <?php foreach ($popularArticles as $key => $popular) : ?>
                        <div class="latest_style_1_item my-3">
                            <span class="item-count vertical-align"><?= ($key + 1) ?>.</span>
                            <div class="alith_post_title_small">
                                <a href="<?= URL_ROOT . "article/{$popular->article_id}/{$token}" ?>"><strong><?= StringUtils::excerpt($popular->title, 60) ?></strong></a>
                                <p class="meta"><span><?= date("d M, Y", strtotime($popular->created_at)) ?></span> <span><?= $popular->views ?> views</span></p>
                            </div>
                            <figure class="alith_news_img"><a href="<?= URL_ROOT . "article/{$popular->article_id}/{$token}" ?>"><img src="<?= get_image($popular->thumbnail) ?>" alt="<?= $popular->thumbnail_caption ?>" class="img-fluid card-img-size" /></a></figure>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div> <!--.sidebar-widget-->

        <div class="sidebar-widget animate-box">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Search</span></h4>
            </div>
            <form action="<?= URL_ROOT . "search" ?>" class="search-form" method="get" role="search">
                <label>
                    <input type="search" name="search" value="" placeholder="Search …" class="search-field">
                </label>
                <input type="submit" value="Search" class="search-submit">
            </form>
        </div> <!--.sidebar-widget-->

        <div class="sidebar-widget animate-box">
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
                            <h3 class="alith_post_title">
                                <a href="<?= URL_ROOT . "article/{$trends[0]->article_id}/{$token}" ?>"><strong><?= $trends[0]->title ?></strong></a>
                            </h3>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($trends as $i => $trend) : ?>
                        <?php if ($i !== 0) : ?>
                            <div class="latest_style_2_item">
                                <figure class="alith_news_img"><a href="<?= URL_ROOT . "article/{$trend->article_id}/{$token}" ?>"><img src="<?= get_image($trend->thumbnail) ?>" alt="<?= $trend->thumbnail_caption ?>" class="img-fluid card-img-size" /></a></figure>
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

        <div class="sidebar-widget animate-box">
            <div class="widget-title-cover">
                <h4 class="widget-title"><span>Tags cloud</span></h4>
            </div>
            <div class="alith_tags_all">
                <?php foreach ($uniqueWords as $tag) : ?>
                    <?php $slug = slugString($tag); ?>
                    <a href="<?= URL_ROOT . "article-tags/{$slug}" ?>" class="alith_tagg"><?= $tag ?></a>
                <?php endforeach; ?>
            </div>
        </div> <!--.sidebar-widget-->
    </div>
</aside>