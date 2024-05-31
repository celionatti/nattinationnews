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

<?php $this->setTitle($title ?? "Article Tag"); ?>

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
                <div class="archive-title">
                    <h2><?= reverseSlug($tag) ?></h2>
                </div>
                <div class="bread">
                    <ul class="breadcrumbs" id="breadcrumbs">
                        <li class="item-home"><a class='bread-link bread-home' href="<?= URL_ROOT ?>" title='Home'>Home</a></li>
                        <li class="separator separator-home"> /</li>
                        <li class="item-current item-cat"><strong class="bread-current bread-cat"><?= reverseSlug($tag) ?></strong></li>
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
                            <?php if ($articles) : ?>
                                <?php foreach ($articles as $article) : ?>
                                    <article class="col-md-6 animate-box section_margin">
                                        <div class="wrap">
                                            <figure class="alith_news_img">
                                                <span class="post_meta_categories_label"><?= stringTags($article->tags) ?></span>
                                                <a href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>"><img src="<?= get_image($article->thumbnail) ?>" alt="<?= $article->thumbnail_caption ?>" class="img-fluid w-100 rounded-2" style="height:357px;object-fit:cover;" /></a>
                                            </figure>
                                        </div>
                                        <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>"><?= $article->title ?></a></h3>
                                        <div class="post_meta">
                                            <a class='meta_author_avatar' href="<?= URL_ROOT . "author/{$article->user_id}" ?>"><img src="<?= get_image("", "avatar") ?>" alt="author details" /></a>
                                            <span class="meta_author_name text-capitalize"><a class='author' href="<?= URL_ROOT . "author/{$article->user_id}" ?>"><?= getCombinedData(getArticleUser($article->user_id), "surname", "name") ?></a></span>
                                            <span class="meta_date"><?= date("d M, Y", strtotime($article->created_at)) ?></span>
                                        </div>
                                        <p class="alith_post_except"><?= StringUtils::excerpt(htmlspecialchars_decode(nl2br($article->content)), 350) ?></p>
                                        <div class="line-space"></div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <h4 class="border-bottom border-2 py-2 px-4">No Tag Article Found!</h4>
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