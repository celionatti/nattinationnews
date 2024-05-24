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

<?php $this->setTitle($title ?? "Admin | Admin Dashboard"); ?>


<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<div class="row">
    <div class="col-12">
        <div class="card border-dark mb-4">
            <div class="card-body">
                <p class="text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur error odio eius deserunt explicabo id atque sed dolorem tenetur voluptatibus necessitatibus minima officiis dolores, magnam vitae doloremque dolorum rerum corporis molestiae cum commodi sit veniam debitis. Atque vel mollitia sapiente cupiditate distinctio placeat dolores a, perferendis, velit aspernatur consequatur sunt?
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Card -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary-subtle mb-4">
                    <div class="card-body">
                        <h4>Manage Users</h4>
                        <h2 class="text-center">
                            <i class="bi bi-people"></i>
                        </h2>
                        <a href="<?= URL_ROOT . 'admin/manage-users' ?>" class="btn btn-outline-primary btn-sm w-100">Details</a>
                    </div>
                </div>
            </div>
            <!-- End Card. -->
        </div>

    </div>
</div>

<hr>

<?php $this->end() ?>