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

<div class="row">
    <div class="col-12">
        <div class="card border-dark mb-4">
            <div class="card-body">
                <p class="text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur error odio eius deserunt explicabo id atque sed dolorem tenetur voluptatibus necessitatibus minima officiis dolores, magnam vitae doloremque dolorum rerum corporis molestiae cum commodi sit veniam debitis. Atque vel mollitia sapiente cupiditate distinctio placeat dolores a, perferendis, velit aspernatur consequatur sunt?
                </p>
                <div class="row">
                    
                </div>

            </div>
        </div>
    </div>
</div>

<hr>

<?php $this->end() ?>