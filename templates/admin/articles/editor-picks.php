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

<?php $this->setTitle($title ?? "Admin | Editor's Pick"); ?>

<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<div class="row g-5">
    <div class="col-md-12">

        <div class="bg-danger-subtle p-2 shadow d-flex justify-content-between align-items-center gap-2">
            <a href="<?= URL_ROOT . "admin/articles/create?ut=file" ?>" class="btn btn-primary btn-sm">Create Article</a>
            <a href="<?= URL_ROOT . "admin/articles/drafts" ?>" class="btn btn-info btn-sm">Draft Articles</a>
            <a href="<?= URL_ROOT . "admin/articles/editors-pick" ?>" class="btn btn-warning btn-sm">Editor's Pick</a>
            <a href="<?= URL_ROOT . "admin/articles/featured-articles" ?>" class="btn btn-success btn-sm">Featured Articles</a>
        </div>

        <hr>

        <div class="table-responsive" id="showeditors">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>

    </div>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showEditorsPick();

        // Show All editors.
        function showEditorsPick() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/articles/view-editors-pick",
                type: "POST",
                data: {
                    action: "editors-pick"
                },
                success: function(response) {
                    $("#showeditors").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>