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

<?php $this->setTitle($title ?? "Admin | Edit Region"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">

    <div class="col-12">
        <h4 class="mb-3">Edit Region</h4>
        <?= BootstrapForm::openForm("") ?>
        <?= BootstrapForm::csrfField() ?>

        <?= BootstrapForm::inputField("Region Name", "region", old_value("region", $region->region ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <?= BootstrapForm::textareaField("Region Info", "region_info", old_value("region_info", $region->region_info ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <?= BootstrapForm::selectField("Status", "status", $region->status ?? '', $statusOpts, ['class' => 'form-control'], ['class' => 'col-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Update Region", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

        <?= BootstrapForm::closeForm() ?>
    </div>

</div>
<?php $this->end() ?>