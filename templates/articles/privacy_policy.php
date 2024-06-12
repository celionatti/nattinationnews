<?php

/**
 * Framework Title: Bolt Framework
 * Creator: Celio natti
 * version: 1.0.0
 * Year: 2023
 *
 */

use celionatti\Bolt\Forms\BootstrapForm;
use celionatti\Bolt\Helpers\Utils\StringUtils;


?>

<?php $this->setTitle($title ?? "Privacy Policy"); ?>

<?php $this->start('header') ?>
<style>
    :root {
        --bs-body-bg: transparent;
        /* Default background color */
    }
</style>
<?php $this->end() ?>

<?php $this->start('content') ?>

<div class="container-fluid">
    <div class="container">
        <div class="primary margin-15">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold mb-3">Privacy Policy</h2>

                    <div class="container shadow px-4 py-4 border">
                        <?= htmlspecialchars_decode(nl2br(setting("policy"))) ?>
                    </div>
                </div>
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end() ?>