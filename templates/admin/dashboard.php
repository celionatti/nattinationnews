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


<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary-subtle mb-4">
            <div class="card-body">
                <h4>New Article</h4>
                <h2 class="text-center">
                    <i class="bi bi-newspaper"></i>
                </h2>
                <a href="<?= URL_ROOT . 'admin/articles?ut=file' ?>" class="btn btn-outline-primary btn-sm w-100">Details</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning-subtle mb-4">
            <div class="card-body">
                <h4>New User</h4>
                <h2 class="text-center">
                    <i class="bi bi-person-plus"></i>
                </h2>
                <a href="<?= URL_ROOT . 'admin/users?ut=file' ?>" class="btn btn-outline-warning btn-sm w-100">Details</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success-subtle mb-4">
            <div class="card-body">
                <h4>Contact Messages</h4>
                <h2 class="text-center">
                    <i class="bi bi-envelope"></i>
                </h2>
                <a href="<?= URL_ROOT . 'admin/manage-messages' ?>" class="btn btn-outline-success btn-sm w-100">Details</a>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info-subtle mb-4">
            <div class="card-body">
                <h4>Manage Comments</h4>
                <h2 class="text-center">
                    <i class="bi bi-gear-wide"></i>
                </h2>
                <a href="<?= URL_ROOT . 'admin/manage-comments' ?>" class="btn btn-outline-info btn-sm w-100">Details</a>
            </div>
        </div>
    </div>
</div>

<hr>

<?php $this->end() ?>