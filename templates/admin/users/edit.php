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

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-5 col-lg-4 order-md-last">
        <hr class="col-6 mb-3">

        <div class="d-flex justify-content-center align-items-center p-2">
            <img src="<?= get_image($user->avatar); ?>" alt="" class="mx-auto d-block image-preview" style="height:250px;width:300px;object-fit:cover;border-radius: 10px;cursor: pointer;">
        </div>
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Edit User</h4>
        <?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
        <?= BootstrapForm::csrfField() ?>
        <div class="row g-3">
            <?= BootstrapForm::inputField("User ID", "", generateUuidV4(), ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'col-sm-12'], $errors) ?>
            <?= BootstrapForm::fileField("Avatar", "avatar", ['class' => 'form-control', 'onchange' => "preview_image(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>
            <?= BootstrapForm::inputField("Surname", "surname", old_value("surname", $user->surname ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-6'], $errors) ?>
            <?= BootstrapForm::inputField("Othername", "othername", old_value("othername", $user->othername ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-6'], $errors) ?>
            <?= BootstrapForm::inputField("E-mail", "email", old_value("email", $user->email ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            <?= BootstrapForm::inputField("Phone", "phone", old_value("phone", $user->phone ?? ''), ['class' => 'form-control', 'type' => 'tel'], ['class' => 'col-sm-6'], $errors) ?>
            <?= BootstrapForm::selectField("Gender", "gender", $user->gender ?? '', $genderOpts, ['class' => 'form-control'], ['class' => 'col-sm-6'], $errors) ?>
            <?= BootstrapForm::selectField("Role", "role", $user->role ?? '', $roleOpts, ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
        </div>

        <hr class="my-4">

        <?= BootstrapForm::submitButton("Update User", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
        <?= BootstrapForm::closeForm() ?>
    </div>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    function preview_image(file) {
        document.querySelector(".image-preview").src = URL.createObjectURL(file);
    }
</script>
<?php $this->end() ?>