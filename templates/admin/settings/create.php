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

<?php $this->setTitle($title ?? "Admin | Create Setting"); ?>

<?php $this->start('header') ?>
<!-- Include Quill stylesheet -->
<link href="<?= get_package("summernote/summernote-lite.min.css") ?>" rel="stylesheet">
<?php $this->end() ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="col-md-12">
    <?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
    <?= BootstrapForm::csrfField() ?>
    <div class="row g-5">

        <div class="col-md-12">
            <div class="row g-3">
                <?= BootstrapForm::inputField("Setting ID", "", generateUuidV4(), ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'col-sm-4'], $errors) ?>

                <?= BootstrapForm::inputField("Setting Name", "name", old_value("name", $setting["name"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-8'], $errors) ?>
                <?= BootstrapForm::textareaField("Setting Value", "value", old_value("value", $setting["value"] ?? ''), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>
            </div>

            <?= BootstrapForm::submitButton("Create Setting", "btn btn-dark btn-sm mx-1 my-2 fs-6 w-100") ?>
        </div>
    </div>
    <?= BootstrapForm::closeForm() ?>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script src="<?= get_package("summernote/summernote-lite.min.js") ?>"></script>
<script>
    $('.summernote').summernote({
        placeholder: 'Setting Value',
        tabsize: 2,
        height: 100,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear', 'fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'height']],
        ],
        spellCheck: true,
    });
</script>
<?php $this->end() ?>