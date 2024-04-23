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


?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-12">

        <div class="controls d-flex justify-content-between align-items-center">
            <a href="<?= URL_ROOT . "admin/manage-comments" ?>" class="btn btn-outline-warning btn-sm px-3"><i class="bi bi-chat-text"></i> Active Comments</a>
        </div>

        <hr>

        <div class="col-lg-12">
            <div class="table-responsive" id="showcomments">
                <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
            </div>
        </div>

    </div>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showAllComments();

        // Show All comments.
        function showAllComments() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/view-failed-comments",
                type: "POST",
                data: {
                    action: "view-failed-comments"
                },
                success: function(response) {
                    $("#showcomments").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>