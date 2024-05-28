<?php


/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */


use celionatti\Bolt\Authentication\BoltAuthentication;


$user = BoltAuthentication::currentUser();

?>


<div class="col-lg-4 col-xl-3">
    <div class="card border p-3 w-100 mb-3">
        <!-- Card header -->
        <div class="card-header text-center border-bottom">
            <!-- Avatar -->
            <div class="avatar avatar-xl position-relative mb-2">
                <img class="avatar-img rounded-circle border border-2 border-white" src="<?= get_image($user->avatar, "avatar") ?>" alt="">
            </div>
            <h6 class="mb-0 text-capitalize"><?= $user->surname . ' ' . $user->name ?></h6>
            <a class="text-reset text-primary-hover small"><?= $user->email ?></a>
        </div>

        <!-- Card body START -->
        <div class="card-body p-0 mt-4">
            <!-- Sidebar menu item START -->
            <ul class="nav nav-pills-primary-border-start flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="account-projects.html"><i class="bi bi-briefcase fa-fw me-2"></i>My projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URL_ROOT . "admin/change-password" ?>"><i class="bi bi-shield-lock fa-fw me-2"></i>Change Password</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= URL_ROOT . "admin/delete-profile" ?>"><i class="bi bi-trash fa-fw me-2"></i>Delete profile</a>
                </li>
            </ul>
            <!-- Sidebar menu item END -->
        </div>
        <!-- Card body END -->
    </div>
</div>