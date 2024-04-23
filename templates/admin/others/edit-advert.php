<?php

/**
 * Framework Title: PhpStrike Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 * 
 */

use celionatti\Bolt\Forms\BootstrapForm;

?>

<?php $this->start('header') ?>
<!-- Include Quill stylesheet -->
<link href="<?= get_package("summernote/summernote-lite.min.css") ?>" rel="stylesheet">
<?php $this->end() ?>
<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<?= BootstrapForm::openForm("", 'POST', 'multipart/form-data') ?>
<?= BootstrapForm::csrfField() ?>
<div class="row g-5">

    <div class="col-md-5 col-lg-4 order-md-last">
        <hr class="col-6 mb-3">

        <div class="d-flex flex-column justify-content-center align-items-center p-2">
            <div class="card shadow my-2 p-2 w-100">
                <h5 class="text-start">File Type</h5>
                <?php if ($upload_type === "file") : ?>
                    <a href="<?= URL_ROOT ?>admin/edit-advert/<?= $advert_id ?>?ut=link" class="btn btn-outline-secondary my-2">Link Upload</a>
                <?php else : ?>
                    <a href="<?= URL_ROOT ?>admin/edit-advert/<?= $advert_id ?>?ut=file" class="btn btn-outline-primary my-2">File Upload</a>
                <?php endif; ?>
            </div>

            <div class="card shadow my-2 p-2">
                <h2 class="text-center">Image</h2>
                <img src="<?= get_image($advert->advert_img); ?>" alt="" class="mx-auto d-block image-preview" style="height:250px;width:300px;object-fit:cover;border-radius: 10px;cursor: pointer;">

                <?php if ($upload_type === "file") : ?>
                    <?= BootstrapForm::fileField("Advert Image", "advert_img", ['class' => 'form-control', 'onchange' => "preview_image(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>
                <?php else : ?>
                    <?= BootstrapForm::inputField("Advert Image", "advert_img", old_value("advert_img", $advert->advert_img ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Edit Advert</h4>
        <div class="row g-3">
            <?= BootstrapForm::inputField("Advert ID", "", generateUuidV4(), ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Advert Name", "name", old_value("name", $advert->name ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Advert Link", "ads_link", old_value("ads_link", $advert->ads_link ?? ''), ['class' => 'form-control', 'type' => 'url'], ['class' => 'col-sm-12'], $errors) ?>
        </div>

        <hr class="my-4">

        <?= BootstrapForm::selectField("Advert Priority", "priority", $advert->priority ?? '', $priorityOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

        <?= BootstrapForm::selectField("Advert Status", "status", $advert->status ?? '', $statusOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Edit Advert", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
    </div>
</div>
<?= BootstrapForm::closeForm() ?>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script src="<?= get_package("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function preview_image(file) {
        document.querySelector(".image-preview").src = URL.createObjectURL(file);
    }
</script>
<?php $this->end() ?>