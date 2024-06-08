<?php

/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 * 
 * This view page start name{style,script,content} 
 * can be edited, base on what they are called in the layout view
 */

?>

<div class="container-fluid alith_footer_right_reserved">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 bottom-logo">
                <h1 class="logo"><a href="<?= URL_ROOT ?>"><span class="text-success">N</span>ATTI <span class="text-success">N</span>ATION</a></h1>
                <div class="tagline social">
                    <ul>
                        <?php if (setting("facebook_link")) : ?>
                            <li class="facebook"><a href="<?= setting("facebook_link") ?>"><i class="fa-brands fa-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (setting("x_link")) : ?>
                            <li class="twitter"><a href="<?= setting("x_link") ?>"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (setting("youtube_link")) : ?>
                            <li class="google-plus"><a href="<?= setting("youtube_link") ?>"><i class="fa-brands fa-youtube"></i></a></li>
                        <?php endif; ?>
                        <?php if (setting("instagram_link")) : ?>
                            <li class="instagram"><a href="<?= setting("instagram_link") ?>"><i class="fa-brands fa-instagram"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-12 d-flex justify-content-evenly align-items-center text-center my-3">
                <a href="<?= URL_ROOT . "privacy-policy" ?>">Privacy Policy</a>
                <a href="<?= URL_ROOT . "contact" ?>">Contact Us</a>
                <a href="<?= URL_ROOT . "term-conditions" ?>">T & C's</a>
            </div>
            <div class="col-12 col-md-12 coppyright">
                <p>© Copyright 2023, All rights reserved. Design by <a href="https://alithemes.com" title="AliTheme">Alithemes.com</a></p>
            </div>
        </div>
    </div>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><span><i class="fa-solid fa-circle-arrow-up fa-3x"></i></span></a>
</div>