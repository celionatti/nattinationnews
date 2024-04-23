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
                    <a href="<?= URL_ROOT ?>admin/edit-resource/<?= $resource_id ?>?ut=link" class="btn btn-outline-secondary my-2">Link Upload</a>
                <?php else : ?>
                    <a href="<?= URL_ROOT ?>admin/edit-resource/<?= $resource_id ?>?ut=file" class="btn btn-outline-primary my-2">File Upload</a>
                <?php endif; ?>
            </div>
            <div class="card shadow my-2 p-2">
                <h2 class="text-center">Thumbnail Image</h2>
                <img src="<?= get_image($resource->thumbnail); ?>" alt="<?= $resource->thumbnail_caption ?>" class="mx-auto d-block thumbnail-preview" style="height:250px;width:300px;object-fit:cover;border-radius: 10px;cursor: pointer;">

                <?php if ($upload_type === "file") : ?>
                    <?= BootstrapForm::fileField("Thumbnail", "thumbnail", ['class' => 'form-control', 'onchange' => "preview_thumbnail(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>
                <?php else : ?>
                    <?= BootstrapForm::inputField("Thumbnail", "thumbnail", old_value("thumbnail", $resource->thumbnail ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
                <?php endif; ?>

                <?= BootstrapForm::inputField("Resource Thumbnail Caption", "thumbnail_caption", old_value("thumbnail_caption", $resource->thumbnail_caption ?? $resource["thumbnail_caption"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            </div>
        </div>
    </div>
    <div class="col-md-7 col-lg-8">
        <div class="row g-3">
            <?= BootstrapForm::inputField("Resource ID", "", generateUuidV4(), ['class' => 'form-control', 'disabled' => 'disabled'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::selectField("Resource Category", "category", $resource->category ?? '', $categoryOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

            <?= BootstrapForm::inputField("Resource Title", "title", old_value("title", $resource->title ?? $resource["title"]), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::textareaField("Resource Content", "content", old_value("content", $resource->content ?? $resource["content"]), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>

            <?php if (isset($resource->resource) && !empty($resource->resource)) : ?>
                <div class="bg-primary w-100 p-3 fw-bold text-white">Resource File: &nbsp;&nbsp;<span class="text-break"><?= $resource->resource ?></span></div>
            <?php endif; ?>

            <?php if ($upload_type === "file") : ?>
                <?= BootstrapForm::fileField("Resources File", "resource", ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            <?php else : ?>
                <?= BootstrapForm::inputField("Resources Link", "resource", $resource->resource ?? '', ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            <?php endif; ?>

            <?= BootstrapForm::inputField("Resource Meta Title", "meta_title", old_value("meta_title", $resource->meta_title ?? $resource["meta_title"]), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Resource Meta Description", "meta_description", old_value("meta_description", $resource->meta_description ?? $resource["meta_description"]), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Resource Meta Keywords", "meta_keywords", old_value("meta_keywords", $resource->meta_keywords ?? $resource["meta_keywords"]), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
        </div>

        <hr class="my-4">

        <?= BootstrapForm::selectField("Resource Status", "status", $resource->status ?? '', $statusOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Update Resource", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
    </div>
</div>
<?= BootstrapForm::closeForm() ?>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script src="<?= get_package("summernote/summernote-lite.min.js") ?>"></script>
<script>
    function preview_thumbnail(file) {
        document.querySelector(".thumbnail-preview").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Resource Content',
        tabsize: 2,
        height: 300
    });
</script>
<?php $this->end() ?>