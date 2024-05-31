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
                    <img class="section_margin_20" src="<?= get_image($user->avatar, "avatar") ?>" alt="author details" />
                    <div class="archive-title">
                        <h2 class="text-capitalize logo-script"><?= $user->surname . ' ' . $user->name ?></h2>
                    </div>
                    <p><?= htmlspecialchars_decode(nl2br($user->bio)) ?></p>
                    <ul>
                        <li><a href="<?= $user->facebook ?>"><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href="<?= $user->twitter ?>"><i class="fa-brands fa-x-twitter"></i></a></li>
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
                    <h3 class="section_margin text-capitalize">Articles written by <?= $user->surname . ' ' . $user->name ?></h3>
                    <div class="post_list post_list_style_1">
                        <?php if ($articles) : ?>
                            <?php foreach ($articles as $article) : ?>
                                <article class="row section_margin animate-box shadow border-bottom border-info border-1 py-2 px-1 me-1 rounded">
                                    <div class="col-md-4 animate-box">
                                        <figure class="alith_news_img shadow"><a href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>"><img src="<?= get_image($article->thumbnail) ?>" alt="<?= $article->thumbnail_caption ?>" class="img-fluid img-size" /></a></figure>
                                    </div>
                                    <div class="col-md-8 animate-box">
                                        <h3 class="alith_post_title"><a href='/single'><?= $article->title ?></a></h3>
                                        <div class="post_meta">
                                            <span class="meta_categories"><?= displayTags($article->tags) ?></span>
                                            <span class="meta_date"><?= date("d M, Y", strtotime($article->created_at)) ?></span>
                                        </div>
                                        <p class="alith_post_except"><?= StringUtils::excerpt(htmlspecialchars_decode(nl2br($article->content)), 350) ?></p>
                                        <a class='read_more btn border border-2 border-dark px-3 py-2 mt-3' href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>">Read More</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <h4 class="border-bottom border-2 py-2 px-4">No Author Article Found!</h4>
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