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

<?php $this->setTitle($title ?? "Admin | Manage Settings"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-12">

        <div class="bg-body-subtle py-2 px-4 shadow d-flex justify-content-between align-items-center">
            <a href="<?= URL_ROOT . "admin/settings/create" ?>" class="btn btn-primary btn-sm px-3">Create</a>
        </div>

        <hr>

        <div class="table-responsive" id="showsettings">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>

    </div>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        showAllSettings();

        // Show All messages.
        function showAllSettings() {
            $.ajax({
                url: "<?= URL_ROOT ?>admin/view-settings",
                type: "POST",
                data: {
                    action: "view-settings"
                },
                success: function(response) {
                    $("#showsettings").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }
    });
</script>
<?php $this->end() ?>