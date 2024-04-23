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
        width: 1530px;
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
                <img src="<?= get_image("assets/img/background-auth.png") ?>" alt="" class="img-fluid" style="width: 250px;">
            </div>
            <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight:600;">Create an Account</p>
            <small class="text-white text-wrap text-center" style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Join us today on this platform.</small>
        </div>

        <div class="col-md-6 right-box">
            <div class="row align-items-center">
                <div class="header-text mb-2">
                    <h2>Hello,</h2>
                    <p class="fst-italic">We are happy to have you in our nation.</p>
                </div>
                <?= BootstrapForm::openForm("", 'POST', null, ['class' => 'row g-1']) ?>
                <?= BootstrapForm::csrfField() ?>
                <div class="col-md-6 col-sm-12">
                    <?= BootstrapForm::inputField("Surname", "surname", old_value("surname", $user["surname"] ?? ''), ['class' => 'form-control'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <?= BootstrapForm::inputField("Othername", "othername", old_value("othername", $user["othername"] ?? ''), ['class' => 'form-control'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= BootstrapForm::selectField("Gender", "gender", old_select("gender", $user["gender"] ?? ''), $genderOpts, ['class' => 'form-control'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-8 col-sm-12">
                    <?= BootstrapForm::inputField("Phone", "phone", old_value("phone", $user["email"] ?? ''), ['class' => 'form-control', 'type' => 'tel'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= BootstrapForm::inputField("Email", "email", old_value("email", $user["email"] ?? ''), ['class' => 'form-control', 'type' => 'email'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= BootstrapForm::inputField("Password", "password", old_value("password", $user["password"] ?? ''), ['class' => 'form-control', 'type' => 'password'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <?= BootstrapForm::inputField("Confirm Password", "confirm_password", old_value("confirm_password", $user["confirm_password"] ?? ''), ['class' => 'form-control', 'type' => 'password'], ['class' => 'mb-1'], $errors) ?>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <div class="">
                        <?= BootstrapForm::checkField("Terms and Conditions", "terms", old_value("terms", $user["terms"] ?? ''), ['class' => 'form-check-input'], ['class' => 'mb-1'], $errors) ?>
                    </div>
                </div>
                <?= BootstrapForm::submitButton("Signup", "btn btn-dark btn-sm mx-1 mb-2 fs-6 w-100") ?>

                <?= BootstrapForm::closeForm() ?>

                <div class="input-group mb-2">
                    <button class="btn btn-sm btn-light w-100 fs-6"><img src="<?= get_image("assets/img/google.png") ?>" alt="" style="width: 20px;" class="me-2"><small>Sign In with Google</small></button>
                </div>

                <div class="row text-center">
                    <small>Already have account? <a href="/login">Login</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>

<!-- For Including JS function -->
<?php $this->start('script') ?>
<script>
    $(document).ready(function() {
        let currentStep = 1;

        // Hide all steps initially
        $('.step').not('[data-step="1"]').hide();

        $('.next-step').click(function() {
            const currentForm = $(`.step[data-step="${currentStep}"]`);
            const nextStep = currentStep + 1;
            const nextForm = $(`.step[data-step="${nextStep}"]`);
            const nextButton = $('.next-step');
            const submitButton = $('#submit-btn');

            if (nextForm.length > 0) {
                currentForm.hide();
                nextForm.show();
                currentStep = nextStep;
            }

            if (currentStep === 3) {
                nextButton.hide();
                submitButton.show();
            } else {
                nextButton.show();
                submitButton.hide();
            }
        });

        $('.prev-step').click(function() {
            const currentForm = $(`.step[data-step="${currentStep}"]`);
            const prevStep = currentStep - 1;
            const prevForm = $(`.step[data-step="${prevStep}"]`);
            const nextButton = $('.next-step');
            const submitButton = $('#submit-btn');

            if (prevForm.length > 0) {
                currentForm.hide();
                prevForm.show();
                currentStep = prevStep;

                if (currentStep === 3) {
                    nextButton.hide();
                    submitButton.show();
                } else {
                    nextButton.show();
                    submitButton.hide();
                }
            }
        });


    });
</script>
<?php $this->end() ?>