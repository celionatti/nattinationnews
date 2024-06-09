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

<?php $this->setTitle($title ?? "Admin | Manage Regions"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">

    <div class="bg-body-subtle py-2 px-4 shadow d-flex justify-content-between align-items-center">
        <a href="<?= URL_ROOT . "admin/regions/create" ?>" class="btn btn-primary btn-sm px-3">Create</a>
    </div>

    <div class="table-responsive" id="showregions">
        <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
    </div>

</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showAllRegions();

        // Show All regions.
        function showAllRegions() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/view-regions",
                type: "POST",
                data: {
                    action: "view-regions"
                },
                success: function(response) {
                    $("#showregions").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>