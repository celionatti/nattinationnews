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

<?php $this->setTitle($title ?? "Admin | Admin Profile"); ?>

<?php $this->start('header') ?>
<!-- Include Quill stylesheet -->
<link href="<?= get_package("summernote/summernote-lite.min.css") ?>" rel="stylesheet">

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
                <!-- Personal Information -->
                <?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
                <?= BootstrapForm::csrfField() ?>
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
                                            <img class="avatar-img rounded-circle border border-white border-3 shadow image-preview" src="<?= get_image($user->avatar, "avatar") ?>" alt="">
                                        </span>
                                    </label>
                                    <!-- Upload button -->
                                    <label class="btn btn-sm btn-dark mb-0" for="profile-btn">Change</label>
                                    <input class="form-control d-none" name="avatar" id="profile-btn" type="file" onchange="preview_image(this.files[0])">
                                </div>
                            </div>
                            <!-- Full name -->
                            <?= BootstrapForm::inputField("Surname", "surname", old_value("surname", $user->surname ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>
                            <?= BootstrapForm::inputField("Othername", "name", old_value("name", $user->name ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Email -->
                            <?= BootstrapForm::inputField("Email address", "email", old_value("email", $user->email ?? ''), ['class' => 'form-control', 'type' => 'email'], ['class' => 'col-md-12'], $errors) ?>

                            <!-- Mobile -->
                            <?= BootstrapForm::inputField("Mobile number", "phone", old_value("phone", $user->phone ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Gender -->
                            <?= BootstrapForm::selectField("Gender", "gender", $user->gender ?? "", $genderOpts, ['class' => 'form-select'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Date of Birth -->
                            <?= BootstrapForm::inputField("Date of Birth", "birth_date", old_value("birth_date", $user->birth_date ?? ''), ['class' => 'form-control', 'type' => 'date'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Facebook -->
                            <?= BootstrapForm::inputField("Facebook URL", "facebook", old_value("facebook", $user->facebook ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Twitter -->
                            <?= BootstrapForm::inputField("Twitter URL", "twitter", old_value("twitter", $user->twitter ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Instagram -->
                            <?= BootstrapForm::inputField("Instagram URL", "instagram", old_value("instagram", $user->instagram ?? ''), ['class' => 'form-control'], ['class' => 'col-md-6'], $errors) ?>

                            <!-- Bio Details -->
                            <?= BootstrapForm::textareaField("Bio", "bio", old_value("bio", $user->bio ?? ''), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>

                            <!-- Button -->
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary mb-0">Save Changes</button>
                            </div>

                        </div>
                    </div>
                </div>
                <?= BootstrapForm::closeForm() ?>

            </div>
        </div>

    </div>
</section>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script src="<?= get_package("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function preview_image(file) {
        document.querySelector(".image-preview").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'User Bio',
        tabsize: 2,
        height: 150,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear', 'fontname', 'fontsize']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
        ],
    });
</script>
<?php $this->end() ?>