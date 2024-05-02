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
            <a href="<?= URL_ROOT . "admin/articles/ai-article" ?>" class="btn btn-dark btn-sm">AI Article</a>
        </div>

        <hr>

        <div class="">
            <div class="d-flex justify-content-end mx-3 mb-3">
                <a href="<?= URL_ROOT ?>admin/manage-articles" class="btn btn-sm btn-secondary px-3 py-1 mx-1">Back</a>
                <a href="#" class="btn btn-sm btn-primary px-3 py-1 mx-1">Print</a>
            </div>

            <div class="card p-2">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <img src="<?= get_image($article->thumbnail) ?? $article->thumbnail ?>" alt="" class="rounded" style="height:250px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
                        <div>Thumbnail Caption:&nbsp; <?= $article->thumbnail_caption ?></div>
                    </div>
                    <div class="text-center p-2 mx-2">
                        <h4 class="mt-5 p-1"><?= $article->title ?></h4>

                        <div class="d-flex justify-content-between p-2 mx-2 border-top border-secondary border-3">
                            <h5 class="border-bottom border-primary border-3 pb-1 me-3 text-capitalize">Author:&nbsp; <?= $article->authors ?></h5>
                            <h5 class="border-bottom border-info border-3 pb-1 text-capitalize">Tags:&nbsp; <?= $article->tags ?></h5>
                        </div>
                    </div>
                    <div>
                        <img src="<?= get_image($article->image) ?>" alt="" class="rounded" style="height:250px;width:250px;object-fit:cover;border-radius: 10px;cursor: pointer;">
                        <div>Image Caption:&nbsp; <?= $article->image_caption ?></div>
                    </div>
                </div>

                <div class="card-body">
                    <?= htmlspecialchars_decode(nl2br($article->content)) ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $this->end() ?>