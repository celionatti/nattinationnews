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
                <div class="row g-0">
                    <div class="col-md-4 p-3">
                        <img src="<?= get_image($user->avatar) ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5
                                class="card-title text-capitalize text-center border-bottom border-danger border-3 pb-2">
                                Block User
                                (
                                <?= getCombinedData($user, 'surname', 'othername') ?> )
                            </h5>
                            <p class="card-text h4 text-center text-danger-emphasis">Are you sure, you want to block
                                this user?</p>
                            <table class="table">
                                <tr>
                                    <th>Role: </th>
                                    <td class="text-capitalize">
                                        <?= $user->role ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>E-Mail: </th>
                                    <td>
                                        <?= $user->email ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= URL_ROOT ?>admin/manage-users" class="btn btn-danger"
                                    aria-label="Cancel">Cancel</a>
                                <?= Form::openForm('') ?>
                                <?= Form::csrfField() ?>
                                <?= Form::hidden("is_blocked", "1") ?>
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