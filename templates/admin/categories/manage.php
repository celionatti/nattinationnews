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

<?php $this->setTitle($title ?? "Admin | Manage Categories"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">

    <div class="col-md-5 col-lg-5 order-md-last">
        <h4 class="mb-3 border-bottom border-danger py-1">Create Category</h4>
        <?= BootstrapForm::openForm("/admin/create-categories") ?>
        <?= BootstrapForm::csrfField() ?>

        <?= BootstrapForm::inputField("Category Name", "category", old_value("category", $category["category"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <?= BootstrapForm::textareaField("Category Info", "category_info", old_value("category_info", $category["category_info"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

        <?= BootstrapForm::selectField("Category Parent", "child", old_select("section", $category["child"] ?? ''), $categoryOpts, ['class' => 'form-control'], ['class' => 'col-12 mb-3'], $errors) ?>

        <?= BootstrapForm::selectField("Section", "section", old_select("section", $category["section"] ?? ''), $sectionOpts, ['class' => 'form-control'], ['class' => 'col-12 mb-3'], $errors) ?>

        <?= BootstrapForm::selectField("Status", "status", old_select("status", $category["status"] ?? ''), $statusOpts, ['class' => 'form-control'], ['class' => 'col-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Create Category", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

        <?= BootstrapForm::closeForm() ?>
    </div>
    <div class="col-md-7 col-lg-7">
        <div class="table-responsive" id="showcategories">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>
    </div>

</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showAllCategories();

        // Show All categories.
        function showAllCategories() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/view-categories",
                type: "POST",
                data: {
                    action: "view-categories"
                },
                success: function(response) {
                    $("#showcategories").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>