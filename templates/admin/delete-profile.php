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


use celionatti\Bolt\Forms\BootstrapForm;


?>

<?php $this->setTitle($title ?? "Admin | Delete Account - Profile"); ?>

<?php $this->start('header') ?>
<style>
    .avatar {
        height: 3rem;
        width: 3rem;
        position: relative;
        display: inline-block !important;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        -o-object-fit: cover;
        object-fit: cover;
    }

    .avatar-group {
        padding: 0;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }

    .avatar-group>li {
        position: relative;
    }

    .avatar-group>li:not(:last-child) {
        margin-right: -0.8rem;
    }

    .avatar .avatar-name {
        margin-left: 7px;
    }

    .avatar-xxs {
        height: 1.5rem;
        width: 1.5rem;
    }

    .avatar-xs {
        height: 2.1875rem;
        width: 2.1875rem;
    }

    .avatar-sm {
        height: 2.5rem;
        width: 2.5rem;
    }

    .avatar-lg {
        height: 4rem;
        width: 4rem;
    }

    .avatar-xl {
        height: 5.125rem;
        width: 5.125rem;
    }

    .avatar-xxl {
        height: 5.125rem;
        width: 5.125rem;
    }

    @media (min-width: 768px) {
        .avatar-xxl {
            width: 8rem;
            height: 8rem;
        }
    }

    .avatar-xxxl {
        height: 8rem;
        width: 8rem;
    }

    @media (min-width: 768px) {
        .avatar-xxxl {
            width: 11rem;
            height: 11rem;
        }
    }
</style>
<?php $this->end() ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<section class="pt-sm-7">
    <div class="container pt-3 pt-xl-5">
        <div class="row">
            <!-- Sidebar -->
            <?= partials("profile-sidebar") ?>

            <!-- Main content -->
            <div class="col-lg-8 col-xl-9 ps-lg-4 ps-xl-6">
                <!-- Update password -->
                <?= BootstrapForm::openForm("", 'POST') ?>
                <?= BootstrapForm::csrfField() ?>
                <div class="card bg-transparent p-0 px-3 py-1">
                    <!-- Card header -->
                    <div class="card-header bg-transparent border-bottom px-0 text-center">
                        <h6 class="mb-0">Delete Profile</h6>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo, iure odit at modi dolorem ullam quod voluptatibus fuga qui eligendi.</p>
                    </div>

                    <!-- Card body -->
                    <div class="card-body px-0">
                        <!-- Confirm password -->
                        <?= BootstrapForm::inputField("Password", "password", old_value("password", ''), ['class' => 'form-control', 'type' => 'password'], ['class' => 'col-md-12 mb-3'], $errors) ?>

                        <!-- Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-danger mb-0">Delete Account</button>
                        </div>
                    </div>
                </div>
                <?= BootstrapForm::closeForm() ?>

            </div>
        </div>

    </div>
</section>

<?php $this->end() ?>