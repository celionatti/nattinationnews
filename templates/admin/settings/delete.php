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

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-12">

        <div class="container d-flex justify-content-center">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="card-body">
                    <h5 class="card-title text-capitalize text-center border-bottom border-danger border-3 pb-2">
                        Delete Setting
                    </h5>
                    <p class="card-text h4 text-center text-success-emphasis">Are you sure, you want to delete
                        this setting?</p>
                    <table class="table">
                        <tr>
                            <th>Name: </th>
                            <td class="text-capitalize">
                                <?= $setting->name ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Value: </th>
                            <td class="text-capitalize">
                                <?= htmlspecialchars_decode(nl2br($setting->value)) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Status: </th>
                            <td>
                                <?= statusVerification($setting->status) ?>
                            </td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= URL_ROOT ?>admin/settings" class="btn btn-danger" aria-label="Cancel">Cancel</a>
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
<?php $this->end() ?>