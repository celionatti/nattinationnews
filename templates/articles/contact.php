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

<?php $this->setTitle($title ?? "Contact"); ?>

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
    <div class="container">
        <div class="primary margin-15">
            <div class="row">
                <div class="col-md-12">
                    <article class="section_margin">
                        <div class="post-content">
                            <div class="single-header">
                                <h3 class="alith_post_title">Contact us</h3>
                            </div>
                            <div class="single-content animate-box">

                                <div class="column-1 animate-box">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="map" class="section_margin_40"></div> <!--Google map-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>Contact information</h2>
                                            <p><strong>Ouch oh alas crud unnecessary invaluable some goodness opposite hello since audacious far barring and absurdly much boa</strong></p>
                                            <p></p>
                                            <p><i class="fa fa-map-o"></i> Address: No.1 Simple Street, Vivamus</p>
                                            <p><i class="fa fa-envelope-o"></i> Email: contact@alithemes.com</p>
                                            <p><i class="fa fa-mobile-phone"></i> Phone: (+0123) 456 789</p>
                                            <p><i class="fa fa-clock-o"></i> Open hour: 8Am - 6Pm</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h2>Get in touch</h2>
                                            <form action="" method="post" id="commentform" class="comment-form" novalidate="">
                                                <div class="row">
                                                    <div class="comment-form-author col-sm-12 col-md-6"> <label for="author">Name (*)</label> <input type="text" id="author" name="author" placeholder="Your name *" value="" size="30"></div>
                                                    <div class="comment-form-email col-sm-12 col-md-6"> <label for="email">Email (*)</label> <input type="email" id="email" name="email" placeholder="Email *" value="" size="30"></div>
                                                </div>
                                                <p class="comment-form-comment"><label for="comment">Message</label><textarea id="comment" name="comment" cols="45" rows="8" placeholder="Your message" aria-required="true"></textarea></p>

                                                <p class="form-submit"><input type="submit" name="submit" id="submit" class="submit" value="Send Message"> <input type="hidden" name="comment_post_ID" value="80" id="comment_post_ID"> <input type="hidden" name="comment_parent" id="comment_parent" value="0"></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--single content-->
                    </article>
                </div>
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    function initMap() {
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
            center: {
                lat: 44.540,
                lng: -78.546
            },
            zoom: 8
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
<?php $this->end() ?>