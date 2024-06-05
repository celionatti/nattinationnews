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

use celionatti\Bolt\Forms\Form;

?>

<?php $this->setTitle($title ?? "Admin | Manage Advertisements"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-12">

        <div class="container d-flex justify-content-center">
            <div class="card mb-3" style="max-width: 640px;">
                <div class="row g-0">
                    <div class="col-md-4 p-3">
                        <img src="<?= get_image($advert->advert_img) ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title text-capitalize text-center border-bottom border-danger border-3 pb-2">
                                Delete Advert
                            </h5>
                            <p class="card-text h4 text-center text-success-emphasis">Are you sure, you want to delete
                                this advert?</p>
                            <table class="table">
                                <tr>
                                    <th>Advert Name: </th>
                                    <td class="text-capitalize">
                                        <?= $advert->name ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Priority: </th>
                                    <td>
                                        <?= statusVerification($advert->priority) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status: </th>
                                    <td>
                                        <?= statusVerification($advert->status) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created: </th>
                                    <td>
                                        <?= displayDate($advert->created_at) ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= URL_ROOT ?>admin/manage-advertisements" class="btn btn-danger" aria-label="Cancel">Cancel</a>
                                <?= Form::openForm('') ?>
                                <?= Form::csrfField() ?>
                                <button type="submit" class="btn btn-dark"><i class="fa-solid fa-angles-right"></i>
                                    Proceed</button>
                                <?= Form::closeForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $this->end() ?>