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

<?php $this->setTitle($title ?? "Admin | Manage Articles"); ?>

<!-- The Main content is Render here. -->
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

        <div class="card px-4 py-2 shadow mb-2">
            <h4>Generate AI Article</h4>
            <?= BootstrapForm::openForm("", attrs: ['id' => 'ai-form']) ?>
            <?= BootstrapForm::csrfField() ?>

            <div id="errorMessage" class="bg-danger text-white fw-bold px-3 py-1 text-center" style="display: none;"></div>
            <div class="row gap-3 my-3">
                <?= BootstrapForm::inputField("Article Topic", "topic", old_value("topic", $article["topic"] ?? ''), ['class' => 'form-control'], ['class' => 'col-sm-12'], $errors) ?>
            </div>

            <?= BootstrapForm::submitButton("Generate Article", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

            <?= BootstrapForm::closeForm() ?>
        </div>

        <div class="card px-4 py-2 shadow mb-2" id="showarticle">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>

    </div>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        $("#ai-form").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            $.ajax({
                url: "<?= URL_ROOT ?>admin/articles/view-ai-article",
                type: "POST",
                data: {
                    action: "ai-article",
                    topic: $("#topic").val()
                },
                success: function(response) {
                    $("#showarticle").html(response);
                },
                error: function(xhr, status, error) {
                    var errorMessage;

                    try {
                        errorMessage = JSON.parse(xhr.responseText).error; // Try parsing the response as JSON
                    } catch (e) {
                        errorMessage = xhr.responseText; // If parsing fails, use the response text as-is
                    }

                    // Display the error message on the page
                    $("#errorMessage").text(errorMessage).show();

                    // Set a timer to hide the error message after 3 seconds
                    setTimeout(function() {
                        $("#errorMessage").fadeOut(); // Fade out the error message
                    }, 4000); // 3 seconds (3000 milliseconds)
                }
            });
        });
    });
</script>
<?php $this->end() ?>