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

<div class="container-fluid">
    <div class="container">
        <div class="top_bar margin-15">
            <div class="row">
                <div class="col-md-6 col-sm-12 time">
                    <div class="off-canvas-toggle" id="off-canvas-toggle"><span></span>
                        <p class="sidebar-open">MORE</p>
                    </div>
                    <i class="fa-regular fa-clock"></i><span>&nbsp;&nbsp;&nbsp;Friday, 5 January 2023</span>
                </div>
                <div class="col-md-6 col-sm-12 social">
                    <ul>
                        <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a href=""><i class="fa-brands fa-youtube"></i></a></li>
                    </ul>
                    <div class="top-search">
                        <i class="fa fa-search"></i><span>SEARCH</span>
                    </div>
                    <div class="top-search-form">
                        <form action="#" class="search-form" method="get" role="search">
                            <label>
                                <span class="screen-reader-text">Search for:</span>
                                <input type="search" name="s" value="" placeholder="Search …" class="search-field">
                            </label>
                            <input type="submit" value="Search" class="search-submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 header">
                <h1 class="logo"><a href="<?= URL_ROOT ?>"><span class="text-danger">N</span>ATTI <span class="text-danger">N</span>ATION</a></h1>
                <p class="tagline">NEWSPAPER / MAGAZINE / PUBLISHER</p>
            </div>
        </div>
    </div>
</div>