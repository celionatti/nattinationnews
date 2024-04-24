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
                    <div class="sb-nav-link-icon"><i class="bi bi-archive"></i></div>
                    Manage Categories
                </a>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlog" aria-expanded="false" aria-controls="collapseBlog">
                    <div class="sb-nav-link-icon"><i class="bi bi-postcard"></i></div>
                    Articles
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseBlog" aria-labelledby="blog" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= URL_ROOT . 'admin/manage-articles' ?>">Manage Articles</a>
                        <a class="nav-link" href="<?= URL_ROOT . 'admin/articles/create?ut=file' ?>">Create Article</a>
                    </nav>
                </div>

                <a class="nav-link" href="<?= URL_ROOT . "admin/adverts" ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-tv"></i></div>
                    Manage Adverts
                </a>

                <hr>

                <a class="nav-link" href="<?= URL_ROOT . "admin/settings" ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-gear-wide-connected"></i></div>
                    Settings
                </a>

                <a class="nav-link" href="<?= URL_ROOT ?>">
                    <div class="sb-nav-link-icon"><i class="bi bi-globe-europe-africa"></i></div>
                    Visit Site
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <span class="text-capitalize"><?= getCombinedData(isLoggedIn(), "surname", "othername") ?></span>
        </div>
    </nav>
</div>