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

<?php $this->setTitle($title ?? "Admin | Admin Profile"); ?>

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
            <div class="col-lg-4 col-xl-3">
                <div class="card border p-3 w-100 mb-3">
                    <!-- Card header -->
                    <div class="card-header text-center border-bottom">
                        <!-- Avatar -->
                        <div class="avatar avatar-xl position-relative mb-2">
                            <img class="avatar-img rounded-circle border border-2 border-white" src="<?= get_image("", "avatar") ?>" alt="">
                        </div>
                        <h6 class="mb-0">Jacqueline Miller</h6>
                        <a href="#" class="text-reset text-primary-hover small">miller@gmail.com</a>
                    </div>

                    <!-- Card body START -->
                    <div class="card-body p-0 mt-4">
                        <!-- Sidebar menu item START -->
                        <ul class="nav nav-pills-primary-border-start flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="account-projects.html"><i class="bi bi-briefcase fa-fw me-2"></i>My projects</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="account-delete.html"><i class="bi bi-trash fa-fw me-2"></i>Delete profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#"><i class="fas fa-sign-out-alt fa-fw me-2"></i>Sign Out</a>
                            </li>
                        </ul>
                        <!-- Sidebar menu item END -->
                    </div>
                    <!-- Card body END -->
                </div>
            </div>

            <!-- Main content -->
            <div class="col-lg-8 col-xl-9 ps-lg-4 ps-xl-6">
                <!-- Update password -->
                <form>
                    <div class="card bg-transparent p-0">
                        <!-- Card header -->
                        <div class="card-header bg-transparent border-bottom px-0">
                            <h6 class="mb-0">Update password</h6>
                        </div>

                        <!-- Card body -->
                        <div class="card-body px-0">
                            <!-- Current password -->
                            <div class="mb-3">
                                <label class="form-label">Current password</label>
                                <input class="form-control" type="password" placeholder="Enter current password">
                            </div>
                            <!-- New password -->
                            <div class="mb-3">
                                <label class="form-label">Enter new password</label>

                                <div class="position-relative">
                                    <input type="password" class="form-control fakepassword pe-6" id="psw-input" placeholder="Enter your password">
                                    <span class="position-absolute top-50 end-0 translate-middle-y p-0 me-2">
                                        <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Confirm password -->
                            <div>
                                <label class="form-label">Confirm new password</label>
                                <input class="form-control" type="password" placeholder="Enter new password">
                            </div>
                            <!-- Button -->
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary mb-0">Change password</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>

<?php $this->end() ?>