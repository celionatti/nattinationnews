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

<?php $this->setTitle($title ?? "Admin | Create User"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
<?= BootstrapForm::csrfField() ?>
<div class="col-md-12">
    <h4 class="mb-3">Create User</h4>
    <div class="row g-3">
        <?= BootstrapForm::inputField("Surname", "surname", old_value("surname", $user["surname"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-6'], $errors) ?>

        <?= BootstrapForm::inputField("Name", "name", old_value("name", $user["name"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-6'], $errors) ?>

        <?= BootstrapForm::inputField("E-Mail", "email", old_value("email", $user["email"] ?? ''), ['class' => 'form-control', 'type' => 'email'], ['class' => 'col-sm-8'], $errors) ?>

        <?= BootstrapForm::inputField("Phone Number", "phone", old_value("phone", $user["phone"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-4'], $errors) ?>

        <?= BootstrapForm::selectField("Gender", "gender", old_select("gender", $user["gender"] ?? ''), $genderOpts, ['class' => 'form-control'], ['class' => 'col-sm-6 mb-3'], $errors) ?>

        <?= BootstrapForm::selectField("Role", "role", old_select("role", $user["role"] ?? ''), $roleOpts, ['class' => 'form-control'], ['class' => 'col-sm-6 mb-3'], $errors) ?>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <div>
            <h5 class="text-center border-bottom border-info py-2">File Info.</h5>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officia aliquam voluptate enim adipisci neque fuga eligendi incidunt, harum, vitae voluptas obcaecati cumque et deleniti ab ducimus, fugiat explicabo possimus a alias veniam id earum. Assumenda laboriosam accusamus enim ad reiciendis nam natus tempora quam. Nemo natus distinctio veniam optio sapiente.</p>
        </div>
        <img src="<?= get_image(); ?>" alt="" class="d-block file-preview" style="height:200px;width:235px;object-fit:cover;border-radius: 10px;cursor: pointer;">
    </div>

    <?= BootstrapForm::fileField("User Docs", "file", ['class' => 'form-control', 'onchange' => "preview_file(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>

    <hr class="my-4">

    <?= BootstrapForm::submitButton("Create User", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
</div>
<?= BootstrapForm::closeForm() ?>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    function preview_file(file) {
        document.querySelector(".file-preview").src = URL.createObjectURL(file);
    }
</script>
<?php $this->end() ?>