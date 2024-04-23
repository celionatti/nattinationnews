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

        <div class="col-lg-12">
            <div class="table-responsive" id="showdrafts">
                <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
            </div>
        </div>

    </div>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function () {
        showAllDrafts();

        // Show All users.
        function showAllDrafts() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/articles/view-drafts",
                type: "POST",
                data: {
                    action: "view-drafts"
                },
                success: function (response) {
                    $("#showdrafts").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>