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

        <div class="bg-body-subtle p-2 shadow d-flex justify-content-between align-items-center gap-2">
            <a href="<?= URL_ROOT . "admin/articles/create?ut=file" ?>" class="btn btn-primary btn-sm">Create Article</a>
            <a href="<?= URL_ROOT . "admin/articles/drafts" ?>" class="btn btn-info btn-sm">Draft Articles</a>
            <a href="<?= URL_ROOT . "admin/articles/editors-pick" ?>" class="btn btn-warning btn-sm">Editor's Pick</a>
            <a href="<?= URL_ROOT . "admin/articles/featured-articles" ?>" class="btn btn-success btn-sm">Featured Articles</a>
        </div>

        <hr>

        <div class="table-responsive" id="showfeatured">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>

    </div>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showFeaturedArticles();

        // Show All editors.
        function showFeaturedArticles() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/articles/view-featured-articles",
                type: "POST",
                data: {
                    action: "featured-articles"
                },
                success: function(response) {
                    $("#showfeatured").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>