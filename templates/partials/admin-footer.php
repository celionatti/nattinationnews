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


<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; <?= setting("site_name", true) ?> <?= date("Y") ?></div>
            <div>
                <a href="<?= URL_ROOT . 'privacy-policy' ?>">Privacy Policy</a>
                &middot;
                <a href="<?= URL_ROOT . 'terms-conditions' ?>">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>