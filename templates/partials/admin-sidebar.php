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


<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="<?= URL_ROOT . 'admin' ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Pages</div>

                <a class="nav-link" href="<?= URL_ROOT . "admin/manage-categories" ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-layer-group"></i></div>
                    Categories
                </a>

                <a class="nav-link" href="<?= URL_ROOT . "admin/manage-regions" ?>">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-book-atlas"></i></div>
                    Regions
                </a>

                <a class="nav-link" href="<?= URL_ROOT . "admin/manage-articles" ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-postcard"></i></div>
                    Articles
                </a>

                <hr>

                <a class="nav-link" href="<?= URL_ROOT . "admin/manage-settings" ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear-wide-connected"></i></div>
                    Settings
                </a>

                <a class="nav-link" href="<?= URL_ROOT ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-globe-europe-africa"></i></div>
                    Visit Site
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer mb-3">
            <div class="small">Logged in as:</div>
            <span class="text-capitalize"><i class="fa-regular fa-circle-dot text-success"></i> <?= getCombinedData(isLoggedIn(), "surname", "name") ?></span>
        </div>
    </nav>
</div>