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

<?php $this->setTitle($title ?? "Admin | Create Article"); ?>

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
                    <a href="<?= URL_ROOT ?>admin/articles/create?ut=link" class="btn btn-outline-secondary my-2">Link Upload</a>
                <?php else : ?>
                    <a href="<?= URL_ROOT ?>admin/articles/create?ut=file" class="btn btn-outline-primary my-2">File Upload</a>
                <?php endif; ?>
            </div>
            <div class="card shadow my-2 p-2">
                <h2 class="text-center">Thumbnail Image</h2>
                <img src="<?= get_image(); ?>" alt="" class="mx-auto d-block thumbnail-preview" style="height:250px;width:300px;object-fit:cover;border-radius: 10px;cursor: pointer;">

                <?php if ($upload_type === "file") : ?>
                    <?= BootstrapForm::fileField("Thumbnail", "thumbnail", ['class' => 'form-control', 'onchange' => "preview_thumbnail(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>
                <?php else : ?>
                    <?= BootstrapForm::inputField("Thumbnail", "thumbnail", old_value("thumbnail", $article["thumbnail"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
                <?php endif; ?>

                <?= BootstrapForm::inputField("Article Thumbnail Caption", "thumbnail_caption", old_value("thumbnail_caption", $article["thumbnail_caption"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            </div>

            <div class="card shadow my-2 p-2">
                <h2 class="text-center">Image</h2>
                <img src="<?= get_image(); ?>" alt="" class="mx-auto d-block image-preview" style="height:250px;width:300px;object-fit:cover;border-radius: 10px;cursor: pointer;">

                <?php if ($upload_type === "file") : ?>
                    <?= BootstrapForm::fileField("Image", "image", ['class' => 'form-control', 'onchange' => "preview_image(this.files[0])"], ['class' => 'col-sm-12'], $errors) ?>
                <?php else : ?>
                    <?= BootstrapForm::inputField("Image", "image", old_value("image", $article["image"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
                <?php endif; ?>

                <?= BootstrapForm::inputField("Article Image Caption", "image_caption", old_value("image_caption", $article["image_caption"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            </div>
        </div>
    </div>
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Create Article</h4>
        <div class="row g-3">
            <?= BootstrapForm::inputField("Article Title", "title", old_value("title", $article["title"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::selectField("Article Category", "category_id", old_select("category_id", $article["category_id"] ?? ''), $categoryOpts, ['class' => 'form-control'], ['class' => 'col-6 mb-3'], $errors) ?>

            <?= BootstrapForm::selectField("Article Region", "region_id", old_select("region_id", $article["region_id"] ?? ''), $regionOpts, ['class' => 'form-control'], ['class' => 'col-6 mb-3'], $errors) ?>

            <?= BootstrapForm::textareaField("Article Content", "content", old_value("content", $article["content"] ?? ''), ['class' => 'form-control summernote'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::textareaField("Article Key Points", "key_point", old_value("key_point", $article["key_point"] ?? ''), ['class' => 'form-control summernote_point'], ['class' => 'col-sm-12'], $errors) ?>

            <?= BootstrapForm::inputField("Article Tags (natti, news)", "tags", old_value("tags", $article["tags"] ?? ''), ['class' => 'form-control'], ['class' => 'col-6'], $errors) ?>

            <?= BootstrapForm::inputField("Article Authors(incl Others)", "authors", old_value("authors", $article["authors"] ?? ''), ['class' => 'form-control'], ['class' => 'col-6'], $errors) ?>
        </div>

        <hr class="my-4">

        <?= BootstrapForm::selectField("Article Status", "status", old_select("status", $article["status"] ?? ''), $statusOpts, ['class' => 'form-control'], ['class' => 'col-sm-12 mb-3'], $errors) ?>

        <?= BootstrapForm::submitButton("Create Article", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>
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

    function preview_thumbnail(file) {
        document.querySelector(".thumbnail-preview").src = URL.createObjectURL(file);
    }

    $('.summernote').summernote({
        placeholder: 'Article Content',
        tabsize: 2,
        height: 300
    });

    $('.summernote_point').summernote({
        placeholder: 'Article Key Points',
        tabsize: 2,
        height: 100
    });
</script>
<?php $this->end() ?>