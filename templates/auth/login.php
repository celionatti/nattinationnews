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

<!-- For Adding CSS Styles -->
<?php $this->start('header') ?>
<style>
    body {
        background-image: url("/assets/img/background-auth.png");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .box-area {
        width: 930px;
    }

    .right-box {
        padding: 40px 30px 40px 40px;
    }

    ::placeholder {
        font-size: 16px;
    }

    @media only screen and (max-width: 768px) {
        .box-area {
            margin: 0 10px;
        }

        .left-box {
            height: 100px;
            overflow: hidden;
        }

        .right-box {
            padding: 20px;
        }
    }
</style>
<?php $this->end() ?>

<!-- The Main content is Render here. -->
<?php $this->start('content') ?>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row boirder rounded-5 p-3 bg-white shadow box-area">
        <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
            <div class="featured-image mb-3">
                <img src="<?= get_image("assets/img/login.png") ?>" alt="" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight:600;">Be Verified</p>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join us today on this platform.</small>
        </div>

        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-2">
                    <h2>Hello, Again</h2>
                    <p class="fst-italic">We are happy to have you in our nation.</p>
                </div>
                <?= BootstrapForm::openForm("", 'POST', null, ['class' => 'row g-1']) ?>
                <?= BootstrapForm::csrfField() ?>
                <div class="col-md-12 col-sm-12">
                    <?= BootstrapForm::inputField("Email", "email", old_value("email", $user["email"] ?? ''), ['class' => 'form-control', 'type' => 'email'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= BootstrapForm::inputField("Password", "password", old_value("password", $user["password"] ?? ''), ['class' => 'form-control', 'type' => 'password'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <div class="">
                        <?= BootstrapForm::checkField("Remember Me", "remember", old_value("remember", $user["remember"] ?? ''), ['class' => 'form-check-input'], ['class' => 'mb-1'], $errors) ?>
                    </div>
                    <div>
                        <a href="/forgot-password">Forgot Password</a>
                    </div>
                </div>
                <?= BootstrapForm::submitButton("Login", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

                <?= BootstrapForm::closeForm() ?>

                <div class="input-group mb-2">
                    <button class="btn btn-sm btn-light w-100 fs-6"><img src="<?= get_image("assets/img/google.png") ?>" alt="" style="width: 20px;" class="me-2"><small>Sign In with Google</small></button>
                </div>

                <div class="row text-center">
                    <small>Don't have account? <a href="/signup">Sign Up</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>