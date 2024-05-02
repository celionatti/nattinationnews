<?php


/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */


use celionatti\Bolt\Authentication\BoltAuthentication;


$currentUser = BoltAuthentication::currentUser();


?>

<div class="main-nav section_margin">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 main_nav_cover mb-3" id="nav">
                    <ul id="main-menu">
                        <li class=""><a href="<?= URL_ROOT ?>">Home</a></li>
                        <li><a href="<?= URL_ROOT . "news" ?>">News</a></li>
                        <li><a href="<?= URL_ROOT . "region/nigeria" ?>">Nigeria</a></li>
                        <li class="menu-item-has-children"><a href='/entertainment'>Entertainment</a>
                            <ul class="sub-menu">
                                <li><a href='/category-big'>Festival</a></li>
                                <li><a href='/category-list'>Music</a></li>
                                <li><a href='/category-grid'>Movie</a></li>
                                <li><a href='/category-list'>Cinema</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children"><a href='/course'>Course</a>
                            <ul class="sub-menu">
                                <li><a href='/course/web-devs'>Web Development</a></li>
                                <li><a href='/course/trading'>Trading(Crypto/Forex)</a></li>
                                <li><a href='/course/marketing'>Marketing</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= URL_ROOT . "jobs" ?>">Jobs</a></li>
                        <li class="menu-item-has-children"><a href='#'>More <i class="fa-solid fa-caret-down"></i></a>
                            <ul class="sub-menu">
                                <li><a href="<?= URL_ROOT . "region/asia" ?>">Asia</a></li>
                                <li><a href="<?= URL_ROOT . "region/usa" ?>">USA</a></li>
                                <li><a href="<?= URL_ROOT . "region/uk" ?>">UK</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>