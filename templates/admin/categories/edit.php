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

<?php $this->setTitle($title ?? "Admin | Edit Categories"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">

    <div class="col-12">
        <h4 class="mb-3">Edit Category</h4>
        <?= BootstrapForm::openForm("") ?>
        <?= BootstrapForm::csrfField() ?>

        <?= BootstrapForm::inputField("Category Name", "category", old_value("category", $category->category ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <?= BootstrapForm::textareaField("Category Info", "category_info", old_value("category_info", $category->category_info ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <div class="row">
            <?= BootstrapForm::selectField("Category Parent", "child", $category->child ?? '', $categoryOpts, ['class' => 'form-control'], ['class' => 'col-4 mb-3'], $errors) ?>

            <?= BootstrapForm::selectField("Section", "section", $category->section ?? '', $sectionOpts, ['class' => 'form-control'], ['class' => 'col-4 mb-3'], $errors) ?>

            <?= BootstrapForm::selectField("Status", "status", $category->status ?? '', $statusOpts, ['class' => 'form-control'], ['class' => 'col-4 mb-3'], $errors) ?>
        </div>

        <?= BootstrapForm::submitButton("Update Category", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

        <?= BootstrapForm::closeForm() ?>
    </div>

</div>
<?php $this->end() ?>