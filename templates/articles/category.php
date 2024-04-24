<?php

/**
 * Framework Title: Bolt Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 *
 */

use celionatti\Bolt\Helpers\Utils\StringUtils;

?>

<?php $this->setTitle($title ?? "Category"); ?>

<?php $this->start('content')?>

<div class="container-fluid">
    <div class="container animate-box">
        <div class="row">
            <div class="archive-header">
                <div class="archive-title">
                    <h2>Festival &amp; Travel</h2>
                </div>
                <div class="archive-description">
                    <p>Auctor est phasellus eget tempor dictumst</p>
                </div>
                <div class="bread">
                    <ul class="breadcrumbs" id="breadcrumbs">
                        <li class="item-home"><a class='bread-link bread-home' href='/' title='Home'>Home</a></li>
                        <li class="separator separator-home"> /</li>
                        <li class="item-current item-cat"><strong class="bread-current bread-cat">House &amp; Living</strong></li>
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
                            <article class="col-md-6 animate-box section_margin">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Politics</span>
                                        <a href='/single'><img src="assets/images/news-1.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam quis </a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_date">Aug 16,2023</span>
                                </div>
                                <p class="alith_post_except">Aliquet accumsan etiam pharetra quisque turpis et metus nullam suspendisse ultricies, eu tempus phasellus platea lectus maecenas lorem sagittis pretium </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box section_margin">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Politics</span>
                                        <a href='/single'><img src="assets/images/news-2.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Tempor posuere conubia primis aenean pulvinar nisi</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Meredith</a></span>
                                    <span class="meta_date">Dec 16,2023</span>
                                </div>
                                <p class="alith_post_except">Est sociosqu gravida euismod erat tortor, amet turpis maecenas metus class enim lectus litora, magna urna morbi quisque non suscipit. </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 sticky animate-box section_margin">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Politics</span>
                                        <a href='/single'><img src="assets/images/news-3.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Laoreet orci faucibus consectetur torquent himenaeos libero</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Joyce</a></span>
                                    <span class="meta_date">Sep 18,2023</span>
                                </div>
                                <p class="alith_post_except">Morbi blandit et curabitur, litora sociosqu sem nisl posuere varius nostra velit dapibus diam, adipiscing a sem et inceptos </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box section_margin">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Politics</span>
                                        <a href='/single'><img src="assets/images/news-4.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Nam class sociosqu taciti aenean nisl vivamus tempor</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Geoffrey</a></span>
                                    <span class="meta_date">Aug 15,2023</span>
                                </div>
                                <p class="alith_post_except">Himenaeos proin tristique vulputate egestas erat in porta pellentesque, ullamcorper porta eget metus accumsan ultricies donec interdum </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Fashion</span>
                                        <a href='/single'><img src="assets/images/news-5.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Nostra purus ut integer potenti sodales, donec nulla ac </a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Fergal</a></span>
                                    <span class="meta_date">Jun 16,2023</span>
                                </div>
                                <p class="alith_post_except">Egestas ultricies inceptos lorem leo fringilla leo posuere platea condimentum mi vitae elementum sodales, nostra purus ut integer potenti. </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Travel</span>
                                        <a href='/single'><img src="assets/images/news-6.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Lacinia semper ut tincidunt mollis quam</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Emery</a></span>
                                    <span class="meta_date">Sep 17,2023</span>
                                </div>
                                <p class="alith_post_except">Volutpat habitant aptent porttitor, nam sit est suscipit quisque nisi curabitur, fermentum . </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box sticky">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Technology</span>
                                        <a href='/single'><img src="assets/images/news-1.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam quis </a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_date">Aug 16,2023</span>
                                </div>
                                <p class="alith_post_except">Aliquet accumsan etiam pharetra quisque turpis et metus nullam suspendisse ultricies, eu tempus phasellus platea lectus maecenas lorem sagittis pretium </p>
                                <div class="line-space"></div>
                            </article>
                            <article class="col-md-6 animate-box">
                                <div class="wrap">
                                    <figure class="alith_news_img">
                                        <span class="post_meta_categories_label">Job</span>
                                        <a href='/single'><img src="assets/images/news-2.jpg" alt="" /></a>
                                    </figure>
                                </div>
                                <h3 class="alith_post_title"><a href='/single'>Tempor posuere conubia primis aenean pulvinar nisi</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="assets/images/author-avatar.png" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Meredith</a></span>
                                    <span class="meta_date">Dec 16,2023</span>
                                </div>
                                <p class="alith_post_except">Est sociosqu gravida euismod erat tortor, amet turpis maecenas metus class enim lectus litora, magna urna morbi quisque non suscipit. </p>
                                <div class="line-space"></div>
                            </article>
                        </div>
                    </div>
                    <div class="site-pagination animate-box">
                        <ul class="page-numbers">
                            <li><a href="#" class="prev page-numbers">PREV</a></li>
                            <li><span class="page-numbers current" aria-current="page">1.</span></li>
                            <li><a href="#" class="page-numbers">2.</a></li>
                            <li><a href="#" class="page-numbers">3.</a></li>
                            <li><a href="#" class="page-numbers">4.</a></li>
                            <li><a href="#" class="next page-numbers">NEXT</a></li>
                        </ul>
                    </div>
                </div>
                <!--Start Sidebar-->
                <?=partials("homepage-sidebar")?>
                <!--End Sidebar-->
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end()?>