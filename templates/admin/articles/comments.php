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
use celionatti\Bolt\Helpers\Utils\TimeUtils;

?>

<?php $this->setTitle($title ?? "Admin | Editor's Pick"); ?>

<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<div class="table-responsive">
    <?php if ($comments) : ?>
        <table class="table table-striped table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Reasons</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $key => $comment) : ?>
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= $comment->name ?></td>
                        <td><?= $comment->comment_text ?></td>
                        <td><?= statusVerification($comment->status) ?></td>
                        <td><?= $comment->failure_reason ?></td>
                        <td><?= TimeUtils::timeAgo($comment->created_at) ?></td>
                        <td>
                            <a href="<?= URL_ROOT . "admin/articles/comments/delete-comment/{$comment->comment_id}" ?>" title='Delete Comment' class='btn btn-sm btn-outline-danger px-3 py-1 my-1'><i class='bi bi-trash'></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <h3 class="text-center text-muted">No Comment yet!</h3>
    <?php endif; ?>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        $("table").DataTable({
            order: [0, 'desc']
        });
    });
</script>
<?php $this->end() ?>