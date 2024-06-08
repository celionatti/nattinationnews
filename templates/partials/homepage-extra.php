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
use PhpStrike\models\Categories;

$articles = new Articles();
$categories = new Categories();

$commentArticles = $articles->getMostCommentArticles(4);
$recents = $articles->getRecentArticles(3);

$categorys = $categories->getFooterCategories();

$token = currentTime();

?>


<div class="container-fluid">
    <div class="container animate-box">
        <div class="bottom margin-15">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="sidebar-widget">
                        <div class="widget-title-cover">
                            <h4 class="widget-title"><span>Most comments</span></h4>
                        </div>
                        <div class="latest_style_3">
                            <?php if ($commentArticles) : ?>
                                <?php foreach ($commentArticles as $key => $comment) : ?>
                                    <div class="latest_style_3_item">
                                        <span class="item-count vertical-align"><?= ($key + 1) ?>.</span>
                                        <div class="alith_post_title_small">
                                            <a href="<?= URL_ROOT . "article/{$comment->article_id}/{$token}" ?>"><strong><?= htmlspecialchars_decode(nl2br($comment->title)) ?></strong></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="sidebar-widget">
                        <div class="widget-title-cover">
                            <h4 class="widget-title"><span>Latest</span></h4>
                        </div>
                        <div class="latest_style_2">
                            <?php if ($recents) : ?>
                                <?php foreach ($recents as $recent) : ?>
                                    <div class="latest_style_2_item">
                                        <figure class="alith_news_img"><a href="<?= URL_ROOT . "article/{$recent->article_id}/{$token}" ?>"><img alt="" src="<?= get_image($recent->thumbnail) ?>" class="hover_grey img-fluid medium-img-size"></a></figure>
                                        <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$recent->article_id}/{$token}" ?>"><?= htmlspecialchars_decode(nl2br($recent->title)) ?></a></h3>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="sidebar-widget">
                        <div class="widget-title-cover">
                            <h4 class="widget-title"><span>Categories</span></h4>
                        </div>
                        <ul class="bottom_menu">
                            <?php if ($categorys) : ?>
                                <?php foreach ($categorys as $category) : ?>
                                    <li><a href="<?= URL_ROOT . "categories/{$category->category}/{$category->category_id}" ?>" class=""><i class="fa fa-angle-right"></i>&nbsp;&nbsp; <?= $category->category ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="sidebar-widget">
                        <div class="widget-title-cover">
                            <h4 class="widget-title"><span>Advertise</span></h4>
                        </div>
                        <div class="banner-adv">
                            <div class="adv-thumb">
                                <?= getAd("medium") ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!--.row-->
        </div>
    </div>
</div>