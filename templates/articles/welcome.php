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

<?php $this->setTitle($title ?? "Home"); ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container animate-box">
        <div class="row">
            <div class="owl-carousel owl-theme js carausel_slider section_margin" id="slider-small">
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href="#"><img src="<?= get_image('assets/img/news-3.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>Lorem ipsum dui sollic itudin </strong></a>
                            <p class="meta"><span>2 Sep, 2023</span> <span>90 views</span></p>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href='/single'><img src="<?= get_image('assets/img/news-1.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>Ut enim ad minima veniam </strong></a>
                            <p class="meta"><span>28 Aug, 2023</span> <span>78 views</span></p>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href='/single'><img src="<?= get_image('assets/img/news-2.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>Quis autem vel eum iure reprerit</strong></a>
                            <p class="meta"><span>16 Aug, 2023</span> <span>112 views</span></p>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href='/single'><img src="<?= get_image('assets/img/chatGPT.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>At vero eos et accu samus et iusto</strong> </a>
                            <p class="meta"><span>15 Jun, 2023</span> <span>328 views</span></p>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href='/single'><img src="<?= get_image('assets/img/chatGPT-1.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>Is very con and rther normal for ing</strong></a>
                            <p class="meta"><span>21 Sep, 2023</span> <span>178 views</span></p>
                        </div>
                    </div>
                </div>
                <div class="item px-2">
                    <div class="alith_latest_trading_img_position_relative">
                        <figure class="alith_post_thumb">
                            <a href='/single'><img src="<?= get_image('assets/img/news-3.jpg') ?>" alt="" class="img-fluid" /></a>
                        </figure>
                        <div class="alith_post_title_small">
                            <a href='/single'><strong>When it comes to selecting a </strong></a>
                            <p class="meta"><span>22 Aug, 2023</span> <span>268 views</span></p>
                        </div>
                    </div>
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
                    <div class="owl-carousel owl-theme js section_margin line_hoz animate-box" id="slideshow_face">
                        <div class="item">
                            <figure class="alith_post_thumb_big">
                                <span class="post_meta_categories_label">Legal, Blog</span>
                                <a href='/single'><img src="<?= get_image('assets/img/news-1.jpg') ?>" alt="" style="width:100%;" class="img-fluid" /></a>
                            </figure>
                            <h3 class="alith_post_title animate-box" data-animate-effect="fadeInUp">
                                <a href='/single'>Lorem ipsum dui sollic itudin praesent ut mollis primis eros torquent fames</a>
                            </h3>
                            <div class="alith_post_content_big">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="post_meta_center animate-box">
                                            <p><a href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" style="width:60px;" /></a></p>
                                            <p><a class='author' href='/page-author'><strong>Steven Job</strong></a></p>
                                            <span class="post_meta_date">19 Sep, 2023</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 animate-box">
                                        <p class="alith_post_except">Is very common and rather normal for blogging beginners to be highly perplexed when it comes to selecting a theme for their blog. There are a plethora of free as well as paid options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <figure class="alith_post_thumb_big">
                                <span class="post_meta_categories_label">Fashion, Men</span>
                                <a href="#"><img src="<?= get_image('assets/img/news-2.jpg') ?>" alt="slide" style="width:100%;" class="img-fluid" /></a>
                            </figure>
                            <h3 class="alith_post_title animate-box" data-animate-effect="fadeInUp">
                                <a href='/single'>Lorem ipsum dui sollic itudin praesent ut mollis primis eros torquent fames</a>
                            </h3>
                            <div class="alith_post_content_big">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="post_meta_center animate-box">
                                            <p><a href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" style="width:60px;" /></a></p>
                                            <p><a class='author' href='/page-author'><strong>Steven Job</strong></a></p>
                                            <span class="post_meta_date">21 Sep, 2023</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 animate-box">
                                        <p class="alith_post_except">Is very common and rather normal for blogging beginners to be highly perplexed when it comes to selecting a theme for their blog. There are a plethora of free as well as paid options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <figure class="alith_post_thumb_big">
                                <span class="post_meta_categories_label">Entertainment, Style</span>
                                <a href="#"><img src="<?= get_image('assets/img/news-3.jpg') ?>" alt="" style="width:100%;" class="img-fluid" /></a>
                            </figure>
                            <h3 class="alith_post_title animate-box" data-animate-effect="fadeInUp">
                                <a href='/single'>Lorem ipsum dui sollic itudin praesent ut mollis primis eros torquent fames</a>
                            </h3>
                            <div class="alith_post_content_big">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="post_meta_center animate-box">
                                            <p><a href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" style="width:60px;" /></a></p>
                                            <p><a class='author' href='/page-author'><strong>Steven Job</strong></a></p>
                                            <span class="post_meta_date">23 Sep, 2023</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 animate-box">
                                        <p class="alith_post_except">Is very common and rather normal for blogging beginners to be highly perplexed when it comes to selecting a theme for their blog. There are a plethora of free as well as paid options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post_list post_list_style_1">
                        <div class="alith_heading">
                            <h2 class="alith_heading_patern_2">Recent Posts</h2>
                        </div>

                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/news-2.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>
                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/news-1.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>Letraset sheets containing Lorem Ipsum passages, and more recently</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>
                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/news-3.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>There are many variations of passages of Lorem Ipsum available, but the majority have suffered</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>
                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/lifestyle-2.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>It uses a dictionary of over 200 Latin words, combined</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>
                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/news-7.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>Reading is not only informed by what’s going on with us at that moment</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>
                        <article class="row section_margin animate-box">
                            <div class="col-md-3 animate-box">
                                <figure class="alith_news_img"><a href='/single'><img src="<?= get_image('assets/img/news-6.jpg') ?>" alt="" /></a></figure>
                            </div>
                            <div class="col-md-9 animate-box">
                                <h3 class="alith_post_title"><a href='/single'>What you see and what you’re experiencing as you read these</a></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image('', 'avatar') ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><a href="archive.html">Politics</a>, <a href="archive.html">News</a></span>
                                    <span class="meta_date">18 Sep, 2023</span>
                                </div>
                            </div>
                        </article>

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