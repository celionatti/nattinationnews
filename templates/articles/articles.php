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

<?php $this->setTitle($title ?? "Articles"); ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container">
        <div class="primary margin-15">
            <div class="row">
                <div class="col-md-8">
                    <div class="post_list post_list_style_1">
                        <?php if ($articles) : ?>
                            <?php foreach ($articles as $article) : ?>
                                <article class="row section_margin animate-box shadow border-bottom border-info border-1 py-2 px-1 me-1 rounded">
                                    <div class="col-md-6 animate-box">
                                        <figure class="alith_news_img"><a href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>"><img src="<?= get_image($article->image) ?>" alt="<?= $article->image_caption ?>" class="img-fluid w-100 rounded-2" style="height:357px;object-fit:cover;" /></a></figure>
                                    </div>
                                    <div class="col-md-6 animate-box">
                                        <h3 class="alith_post_title"><a href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>"><?= $article->title ?></a></h3>
                                        <div class="post_meta">
                                            <a class='meta_author_avatar' href="<?= URL_ROOT . "author/{$article->user_id}" ?>"><img src="<?= get_image("", "avatar") ?>" alt="author details" /></a>
                                            <span class="meta_author_name"><a class='author' href="<?= URL_ROOT . "author/{$article->user_id}" ?>">Steven Job</a></span>
                                            <span class="meta_categories"><?= displayTags($article->tags) ?></span>
                                            <span class="meta_date"><?= date("d M, Y", strtotime($article->created_at)) ?></span>
                                        </div>
                                        <p class="alith_post_except"><?= StringUtils::excerpt(htmlspecialchars_decode(nl2br($article->content)), 350) ?></p>
                                        <a class='read_more btn border border-2 border-dark px-3 py-2 mt-3' href="<?= URL_ROOT . "article/{$article->article_id}/{$token}" ?>">Read More</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
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

<?php $this->end() ?>