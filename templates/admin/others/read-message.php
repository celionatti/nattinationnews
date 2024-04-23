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

<div class="d-flex justify-content-end mx-3 mb-3">
    <a href="<?= URL_ROOT ?>admin/manage-messages" class="btn btn-sm btn-secondary px-3 py-1 mx-1">Back</a>
    <a href="#" class="btn btn-sm btn-primary px-3 py-1 mx-1">Print</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <tr>
                <th>Name:</th>
                <td class="text-capitalize"><?= $message->name ?></td>
                <th>Status:</th>
                <td><?= statusVerification($message->status) ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?= $message->email ?></td>
                <th>Label:</th>
                <td><?= statusVerification($message->label) ?></td>
            </tr>
            <tr>
                <th>Subject:</th>
                <td colspan="2"><?= $message->subject ?></td>
                <td>
                    <?php if ($message->label === "none") : ?>
                        <a href="<?= URL_ROOT . "admin/archive-message/{$message->contact_id}" ?>" title="Archive Message" class="btn btn-sm btn-outline-info"><i class="bi bi-archive"></i></a>
                        <a href="<?= URL_ROOT . "admin/important-message/{$message->contact_id}" ?>" title="Important Message" class="btn btn-sm btn-outline-warning"><i class="bi bi-star"></i></a>
                    <?php elseif ($message->label === "important") : ?>
                        <a href="<?= URL_ROOT . "admin/archive-message/{$message->contact_id}" ?>" title="Archive Message" class="btn btn-sm btn-outline-info"><i class="bi bi-archive"></i></a>
                    <?php elseif ($message->label === "archive") : ?>
                        <a href="<?= URL_ROOT . "admin/important-message/{$message->contact_id}" ?>" title="Important Message" class="btn btn-sm btn-outline-warning"><i class="bi bi-star"></i></a>
                    <?php endif; ?>

                    <a href="<?= URL_ROOT . "admin/delete-message/{$message->contact_id}" ?>" title="Delete Message" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
        </table>
    </div>

    <div class="card-body">
        <h3 class="text-center border-bottom border-3 py-2">Message Content</h3>
        <div class="content">
            <p><?= htmlspecialchars_decode(nl2br($message->message)) ?></p>
        </div>
    </div>
</div>

<?php $this->end() ?>