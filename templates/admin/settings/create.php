<?php

/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */

use celionatti\Bolt\Forms\BootstrapForm;

?>

<?php $this->start('header') ?>
<!-- Include Quill stylesheet -->
<link href="<?= get_package("summernote/summernote-lite.min.css") ?>" rel="stylesheet">
<?php $this->end() ?>
<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
<?= BootstrapForm::csrfField() ?>
<div class="row g-5">
    
    <div class="col-md-12">
        <h4 class="mb-3">Create Setting</h4>
        <div class="row g-3">
            <?= BootstrapForm::inputField("Setting ID", "", generateUuidV4(), ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Setting Name", "name", old_value("name", $setting["name"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            <?= BootstrapForm::textareaField("Setting Value", "value", old_value("value", $setting["value"] ?? ''), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>
        </div>

        <hr class="my-4">

        <?= BootstrapForm::selectField("Setting Status", "status", old_select("status", $setting["status"] ?? ''), $statusOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Create Setting", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
    </div>
</div>
<?= BootstrapForm::closeForm() ?>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script src="<?= get_package("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function preview_image(file) {
        document.querySelector(".image-preview").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Setting Value',
        tabsize: 2,
        height: 300
    });
</script>
<?php $this->end() ?>