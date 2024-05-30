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

<?php $this->start("content") ?>

<?= partials("admin-crumbs", ['title' => $title, 'navigations' => $navigations]) ?>

<div class="container">
    <main>
        <div class="py-2 text-center">
            <h2>Delete Account</h2>
            <p class="lead">Please note that you have to enter the correct Old Password first, then add the new Password you now want. If the Old Password is wrong, you won't be allowed to change the Password. Then you will have to go to forgot Password, or contact one of the Admin. Thank You..</p>
        </div>

        <?= BootstrapForm::openForm("") ?>
        <?= BootstrapForm::csrfField() ?>
        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <div>
                    <img class="img-fluid img-thumbnail" src="<?= get_image($user->avatar, "avatar") ?>" alt="Profile Image">
                </div>
            </div>
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Account details</h4>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Surname:</th>
                            <td class="text-capitalize"><?= $user->surname ?></td>
                            <th>Name:</th>
                            <td class="text-capitalize "><?= $user->name ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td class="text-dark"><?= $user->email ?></td>
                            <th>Phone Number:</th>
                            <td class="text-dark"><?= $user->phone ?></td>
                        </tr>
                        <tr>
                            <th>Gender:</th>
                            <td class="text-capitalize"><?= $user->gender ?></td>
                            <th>Access Role:</th>
                            <td class="text-capitalize"><?= userRoleType($user->role) ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row g-3">
                    <?= BootstrapForm::hidden("user_id", $user->user_id) ?>
                </div>

                <hr class="my-4">

                <?= BootstrapForm::submitButton("Delete Account", "btn btn-danger btn-lg mx-1 mb-2 fs-6 w-100") ?>
            </div>
        </div>
        <?= BootstrapForm::closeForm() ?>
    </main>
</div>

<?php $this->end() ?>