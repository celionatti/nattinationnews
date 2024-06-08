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

                <?= BootstrapForm::inputField("Setting Name", "name", old_value("name", $setting->name ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-8'], $errors) ?>
                <?= BootstrapForm::textareaField("Setting Value", "value", old_value("value", $setting->value ?? ''), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>
            </div>

            <hr class="my-4">

            <?= BootstrapForm::selectField("Setting Status", "status", $setting->status ?? '', $statusOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

            <?= BootstrapForm::submitButton("Update Setting", "btn btn-dark btn-sm mx-1 mt-3 fs-6 w-100") ?>
        </div>
    </div>
    <?= BootstrapForm::closeForm() ?>
</div>
<?php $this->end() ?>