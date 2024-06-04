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

<?php $this->setTitle($title ?? "Admin | Manage Messages"); ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>
<div class="row g-5">
    <div class="col-md-12">

        <div class="table-responsive" id="showmessage">
            <h3 class="text-center text-muted" style="margin-top: 110px;">Loading...</h3>
        </div>

    </div>
</div>
<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    function getURL(urlPattern = /\/admin\/messages\/open\/([^/]+)/) {
        // Get the current URL
        const currentURL = window.location.href;

        // Define the regular expression pattern
        let pattern = urlPattern;

        // Extract the post ID and token from the URL using the pattern
        const match = currentURL.match(pattern);

        // Check if the match is not null and not undefined before returning the result
        if (match && match[1]) {
            return {
                id: match[1],
                url: match["input"]
            };
        }

        // Return null if no match
        return null;
    }

    $(document).ready(function() {
        showMessage();

        // Show All messages.
        function showMessage() {
            const messageUrl = getURL();

            $.ajax({
                url: messageUrl.url,
                type: "POST",
                data: {
                    action: "open-message",
                    message_id: messageUrl.id,
                    open: "true"
                },
                success: function(response) {
                    $("#showmessage").html(response);
                }
            });
        }
    });
</script>
<?php $this->end() ?>