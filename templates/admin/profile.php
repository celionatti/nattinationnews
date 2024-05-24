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
                <!-- Personal Information -->
                <form>
                    <div class="card bg-transparent p-0 px-3 py-1">
                        <!-- Card header -->
                        <div class="card-header bg-transparent border-bottom p-0 pb-3">
                            <h6 class="mb-0">Personal Information</h6>
                        </div>

                        <!-- Card body -->
                        <div class="card-body px-0">
                            <div class="row g-4">
                                <!-- Profile photo -->
                                <div class="px-5 col-12">
                                    <label class="form-label">Profile picture</label>
                                    <div class="d-flex align-items-center">
                                        <label class="position-relative me-2" title="Replace this pic">
                                            <!-- Avatar place holder -->
                                            <span class="avatar avatar-xl">
                                                <img class="avatar-img rounded-circle border border-white border-3 shadow" src="<?= get_image("", "avatar") ?>" alt="">
                                            </span>
                                        </label>
                                        <!-- Upload button -->
                                        <label class="btn btn-sm btn-dark mb-0" for="profile-btn">Change</label>
                                        <input class="form-control d-none" name="avatar" id="profile-btn" type="file">
                                    </div>
                                </div>
                                <!-- Full name -->
                                <div class="col-12">
                                    <label class="form-label">Full name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="surname" value="Jacqueline" placeholder="Surname / First Name">
                                        <input type="text" class="form-control" name="name" value="Miller" placeholder="Other Name">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12">
                                    <label class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" value="hello@gmail.com" placeholder="Enter your email id">
                                </div>

                                <!-- Mobile -->
                                <div class="col-md-6">
                                    <label class="form-label">Mobile number</label>
                                    <input type="text" name="phone" class="form-control" value="222 555 666" placeholder="Enter your mobile number">
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6">
                                    <label class="form-label">Select Gender</label>
                                    <div class="input-group">
                                        <div class="form-control">
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked="">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Male
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-control">
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Female
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-control">
                                            <div class="form-check radio-bg-light">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Others
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-md-6">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="date" name="birth_date" class="form-control" value="02/05/2023" placeholder="Enter your date of birth">
                                </div>

                                <!-- Facebook -->
                                <div class="col-md-6">
                                    <label class="form-label">Facebook URL</label>
                                    <input type="text" name="facebook" class="form-control" value="www.facebook.com/natti-nation" placeholder="Enter your facebook link">
                                </div>

                                <!-- Twitter -->
                                <div class="col-md-6">
                                    <label class="form-label">Twitter / X URL</label>
                                    <input type="text" name="twitter" class="form-control" value="www.x.com/natti-nation" placeholder="Enter your twitter / x link">
                                </div>

                                <!-- Instagram -->
                                <div class="col-md-6">
                                    <label class="form-label">Instagram URL</label>
                                    <input type="text" name="instagram" class="form-control" value="www.instagram.com/natti-nation" placeholder="Enter your instagram link">
                                </div>

                                <!-- Bio Details -->
                                <div class="col-12">
                                    <label class="form-label">Bio</label>
                                    <textarea class="form-control" rows="3" spellcheck="false">2119 N Division Ave, New Hampshire, York, United States</textarea>
                                </div>

                                <!-- Button -->
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-0">Save Changes</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</section>

<?php $this->end() ?>