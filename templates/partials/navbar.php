<?php


/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */


use celionatti\Bolt\Authentication\BoltAuthentication;
use PhpStrike\models\Regions;


$currentUser = BoltAuthentication::currentUser();

$regions = new Regions();
$regionsNav = $regions->getRegions();

?>

<div class="main-nav section_margin">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 main_nav_cover mb-3" id="nav">
                    <ul id="main-menu">
                        <li class=""><a href="<?= URL_ROOT ?>">Home</a></li>
                        <li><a href="<?= URL_ROOT . "news" ?>">News</a></li>
                        <?php categoriesNav() ?>
                        <li class="menu-item-has-children"><a href='#'>More <i class="fa-solid fa-caret-down"></i></a>
                            <ul class="sub-menu">
                                <?php if ($regionsNav) : ?>
                                    <?php foreach ($regionsNav as $regionNav) : ?>
                                        <?php $region = strtolower($regionNav->region) ?>
                                        <li><a href="<?= URL_ROOT . "region/{$region}/{$regionNav->region_id}" ?>"><?= $regionNav->region ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>