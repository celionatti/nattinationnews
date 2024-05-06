<?php

/**
 * Framework Title: Bolt Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 *
 */

use celionatti\Bolt\Forms\BootstrapForm;
use celionatti\Bolt\Helpers\Utils\StringUtils;

?>

<?php $this->setTitle($title ?? "Read Article"); ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container">
        <div class="primary margin-15">
            <div class="row mt-4">
                <div class="col-md-8">
                    <article class="section_margin">
                        <figure class="alith_news_img animate-box"><a><img src="<?= get_image($article->thumbnail) ?>" alt="" class="w-100" /></a></figure>
                        <div class="post-content">
                            <div class="single-header">
                                <h3 class="alith_post_title"><?= htmlspecialchars_decode(nl2br($article->title)) ?></h3>
                                <div class="post_meta">
                                    <a class='meta_author_avatar' href='/page-author'><img src="<?= get_image("", "avatar") ?>" alt="author details" /></a>
                                    <span class="meta_author_name"><a class='author' href='/page-author'>Steven Job</a></span>
                                    <span class="meta_categories"><?= displayTags($article->tags) ?></span>
                                    <span class="meta_date"><?= date("d M, Y", strtotime($article->created_at)) ?></span>
                                </div>
                            </div>

                            <div class="single-content animate-box">

                                <?php if ($article->key_point) : ?>
                                    <div class="alith_post_except animate-box"><?= htmlspecialchars_decode(nl2br($article->key_point)) ?></div>
                                <?php endif; ?>

                                <div class="dropcap column-2 animate-box">
                                    <?= htmlspecialchars_decode(nl2br($article->content)) ?>
                                </div>

                                <div class="post-tags">
                                    <div class="post-tags-inner">
                                        <?= displayArticleTags($article->tags) ?>
                                    </div>
                                </div>

                                <div class="post-share">
                                    <ul>
                                        <li class="facebook"><a href="<?= FACEBOOK_LINK ?>"><i class="fa-brands fa-facebook"></i></a></li>
                                        <li class="twitter"><a href="<?= X_LINK ?>"><i class="fa-brands fa-x-twitter"></i></a></li>
                                        <li class="google-plus"><a href="<?= YOUTUBE_LINK ?>"><i class="fa-brands fa-youtube"></i></a></li>
                                        <li class="instagram"><a href="<?= YOUTUBE_LINK ?>"><i class="fa-brands fa-instagram"></i></a></li>
                                    </ul>
                                </div>

                                <div class="post-author section_margin_40">
                                    <figure class="mx-2 my-4"><a href='/page-author'><img src="<?= get_image("", "avatar") ?>" style="width:95px; height:95px;" class="rounded-circle p-1"></a></figure>
                                    <div class="post-author-info mb-3">
                                        <h3><a href='/page-author'>Steven Jobs</a></h3>
                                        <p>Ouch oh alas crud unnecessary invaluable some goodness opposite hello since audacious far barring and absurdly much boa</p>
                                        <ul>
                                            <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                                            <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                                            <li><a href=""><i class="fa-brands fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="post-related section_margin_40">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="sidebar-widget">
                                                <div class="widget-title-cover">
                                                    <h4 class="widget-title"><span>Related Posts</span></h4>
                                                </div>
                                                <div class="latest_style_3">
                                                    <div class="latest_style_3_item">
                                                        <span class="item-count vertical-align">1.</span>
                                                        <div class="alith_post_title_small">
                                                            <a href='/single'><strong>Frtuitous spluttered unlike ouch vivid blinked far inside</strong></a>
                                                        </div>
                                                    </div>
                                                    <div class="latest_style_3_item">
                                                        <span class="item-count vertical-align">2.</span>
                                                        <div class="alith_post_title_small">
                                                            <a href='/single'><strong>Against and lantern where a and gnashed nefarious</strong></a>
                                                        </div>
                                                    </div>
                                                    <div class="latest_style_3_item">
                                                        <span class="item-count vertical-align">3.</span>
                                                        <div class="alith_post_title_small">
                                                            <a href='/single'><strong>Ouch oh alas crud unnecessary invaluable some</strong></a>
                                                        </div>
                                                    </div>
                                                    <div class="latest_style_3_item">
                                                        <span class="item-count vertical-align">4.</span>
                                                        <div class="alith_post_title_small">
                                                            <a href='/single'><strong>And far hey much hello and bashful one save less</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!--post-related-->
                                        <div class="col-md-6">
                                            <div class="post-navigation">
                                                <div class="latest_style_2">
                                                    <h5><span>Preview Post</span></h5>
                                                    <div class="latest_style_2_item">
                                                        <figure class="alith_news_img"><a href='/single'><img class="hover_grey" src="<?= get_image() ?>" alt=""></a></figure>
                                                        <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam</a></h3>
                                                    </div>

                                                    <h5><span>Next Post</span></h5>
                                                    <div class="latest_style_2_item">
                                                        <figure class="alith_news_img"><a href='/single'><img class="hover_grey" src="<?= get_image() ?>" alt=""></a></figure>
                                                        <h3 class="alith_post_title"><a href='/single'>Magna aliqua ut enim ad minim veniam</a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!--post-related and navigation-->
                            </div> <!--single content-->
                            <div class="single-comment">
                                <section id="comments">
                                    <h4 class="single-comment-title">Comments</h4>
                                    <div class="comments-inner clr">
                                        <div id="showcomments">

                                        </div>
                                        <!--comment list-->

                                        <section class="comment-respond" id="respond">
                                            <h3 class="comment-reply-title" id="reply-title">Leave a Reply <small><a href="#respond" id="cancel-comment-reply-link" rel="nofollow"><i class="fa fa-times"></i></a></small></h3>
                                            <?= BootstrapForm::openForm("", attrs: ['class' => 'comment-form', 'id' => 'commentform']) ?>
                                            <?= BootstrapForm::csrfField() ?>
                                            <?= BootstrapForm::hidden("reply_id", "", ['id' => 'reply_id']) ?>

                                            <p class="comment-notes">
                                            <div class="border border-2 border-success px-2 py-3 bg-success-subtle text-center" id="successMessage" style="display: none;">Your Success Message Here.</div>
                                            </p>
                                            <p class="comment-notes">
                                            <div class="border border-2 border-danger px-2 py-3 bg-danger-subtle text-center" id="errorMessage" style="display: none;"></div>
                                            </p>

                                            <div class="border-bottom border-dark border-3 pb-2 mb-2" style="display:none;" id="reply-to">Reply To: #amisu</div>

                                            <div class="row">
                                                <div class="comment-form-author col-sm-12 col-md-12"> <label for="name">Name (optional)</label> <input type="text" size="30" value="" placeholder="Your name *" name="name" id="name"></div>
                                            </div>

                                            <p class="comment-form-comment"><label for="comment">Comment</label><textarea aria-required="true" placeholder="Your Comment" rows="8" cols="45" name="comment_text" id="comment"></textarea></p>

                                            <p class="form-submit"><input type="submit" value="Post Comment" class="submit" id="submit" name="submit"> <input type="hidden" id="comment_post_ID" value="80" name="comment_post_ID"> <input type="hidden" value="0" id="comment_parent" name="comment_parent"></p>
                                            <?= BootstrapForm::closeForm() ?>
                                        </section> <!--comment form-->

                                    </div>
                                </section>
                            </div>
                        </div>
                    </article>


                </div>
                <!--Start Sidebar-->
                <?= partials("homepage-sidebar") ?>
                <!--End Sidebar-->
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end() ?>


<?php $this->start("script") ?>
<script>
    function getURL(urlPattern = /\/article\/([^/]+)\/([^/]+)/) {
        // Get the current URL
        const currentURL = window.location.href;

        // Define the regular expression pattern
        let pattern = urlPattern;

        // Extract the post ID and token from the URL using the pattern
        const match = currentURL.match(pattern);

        // Check if the match is not null and not undefined before returning the result
        if (match && match[1] && match[2]) {
            return {
                id: match[1],
                token: match[2],
                url: match["input"]
            };
        }

        // Return null if no match
        return null;
    }

    $(document).ready(function() {
        showComments();

        // Add Main Comment
        $("#commentform").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            const articleUrl = getURL();

            $.ajax({
                url: articleUrl.url,
                type: "POST",
                data: {
                    action: "create_comment",
                    name: $("#name").val(),
                    comment_text: $("#comment").val(),
                    reply_id: $("#reply_id").val(),
                    article_id: articleUrl.id
                },
                success: function(response) {
                    $("#name").val("");
                    $("#comment").val("");
                    $("#reply_id").val("");
                    // Display the error message on the page
                    $("#successMessage").text(response).show();

                    $("#reply-to").hide();

                    // Set a timer to hide the error message after 3 seconds
                    setTimeout(function() {
                        $("#successMessage").fadeOut(); // Fade out the error message
                    }, 4000); // 3 seconds (3000 milliseconds)

                    showComments();
                },
                error: function(xhr, status, error) {
                    var errorMessage;

                    try {
                        errorMessage = JSON.parse(xhr.responseText).message; // Try parsing the response as JSON
                    } catch (e) {
                        errorMessage = xhr.responseText; // If parsing fails, use the response text as-is
                    }

                    // Display the error message on the page
                    $("#errorMessage").text(errorMessage).show();

                    // Set a timer to hide the error message after 3 seconds
                    setTimeout(function() {
                        $("#errorMessage").fadeOut(); // Fade out the error message
                    }, 4000); // 3 seconds (4000 milliseconds)
                }
            });
        });

        $(document).on("click", ".reply_btn", function(e) {
            var formId = $('#respond').attr("id");
            var commentId = $(this).val(); // Get the comment ID from the clicked button
            var commentName = $(this).data('comment-name');

            // Display the error message on the page
            $("#reply-to").show();
            $("#reply-to").text("Reply to: " + commentName);
            $('#reply_id').val(commentId);

            var formOffset = $('#' + formId).offset().top;
            var formHeight = $('#' + formId).outerHeight();

            var windowHeight = $(window).height();
            var currentScroll = $(window).scrollTop();

            var scrollTo = formOffset + windowHeight + formHeight + 300;
            
            //var scrollTo = formOffset + windowHeight - 100; // Adjust the scroll position if needed

            $('html, body').animate({
                scrollTop: scrollTo
            }, 1000);
        });

        // Show All comments.
        function showComments() {
            const articleUrl = getURL();

            $.ajax({
                url: articleUrl.url,
                type: "POST",
                data: {
                    article_id: articleUrl.id,
                    article_url: articleUrl.url,
                    token: articleUrl.token,
                    action: "load_comments",
                },
                success: function(response) {
                    $("#showcomments").html(response);
                }
            });
        }
    });
</script>
<?php $this->end() ?>