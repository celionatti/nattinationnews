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

<?php $this->setTitle($title ?? "Contact"); ?>

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
                    <article class="section_margin">
                        <div class="post-content">
                            <div class="single-header">
                                <h3 class="alith_post_title">Contact us</h3>
                            </div>
                            <div class="single-content animate-box">

                                <div class="column-1 animate-box">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <img src="<?= get_image("assets/img/contact-bg.png") ?>" alt="Contact Us" class="img-fluid img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>Contact information</h2>
                                            <p><strong>Ouch oh alas crud unnecessary invaluable some goodness opposite hello since audacious far barring and absurdly much boa</strong></p>
                                            <p></p>
                                            <p><i class="fa fa-map-o"></i> Address: No.1 Simple Street, Vivamus</p>
                                            <p><i class="fa fa-envelope-o"></i> Email: contact@alithemes.com</p>
                                            <p><i class="fa fa-mobile-phone"></i> Phone: (+0123) 456 789</p>
                                            <p><i class="fa fa-clock-o"></i> Open hour: 8Am - 6Pm</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h2>Get in touch</h2>
                                            <div id="errorMessage" class="bg-danger text-white fw-bold px-3 py-1 text-center" style="display: none;"></div>
                                            <div id="successMessage" class="bg-success text-white fw-bold px-3 py-1 text-center" style="display: none;"></div>
                                            <?= BootstrapForm::openForm("", attrs: ['id' => 'commentform', 'class' => 'comment-form']) ?>
                                            <?= BootstrapForm::csrfField() ?>
                                            <div class="row">
                                                <div class="comment-form-author col-sm-12 col-md-6"> <label for="author">Name (*)</label> <input type="text" id="name" name="name" placeholder="Your name *" value="" size="30"></div>
                                                <div class="comment-form-email col-sm-12 col-md-6"> <label for="email">Email (*)</label> <input type="email" id="email" name="email" placeholder="Email *" value="" size="30"></div>
                                            </div>
                                            <p class="comment-form-comment"><label for="comment">Message</label><textarea id="message" name="message" cols="45" rows="8" placeholder="Your message" aria-required="true"></textarea></p>

                                            <p class="form-submit">
                                                <input type="submit" name="submit" id="submit" class="submit" value="Send Message">
                                            </p>
                                            <?= BootstrapForm::closeForm() ?>
                                        </div>
                                    </div>
                                </div>
                            </div> <!--single content-->
                    </article>
                </div>
            </div>
        </div> <!--.primary-->

    </div>
</div>

<?php $this->end() ?>

<?php $this->start("script") ?>
<script>
    $(document).ready(function() {
        $("#commentform").submit(function(e) {
            e.preventDefault();

            var name = $('#name').val().trim();
            var email = $('#email').val().trim();
            var message = $('#message').val().trim();
            var errorMessage = '';

            if (name === "" || email === "" || message === "") {
                errorMessage = "All fields are required!";
            } else if (!validateEmail(email)) {
                errorMessage = "Invalid email format!";
            }

            if (errorMessage) {
                $("#errorMessage").text(errorMessage).show();
                setTimeout(function() {
                    $("#errorMessage").fadeOut(); // Ensure this line is being called
                }, 4000); // 4 seconds (4000 milliseconds)
                return;
            }

            $.ajax({
                url: "<?= URL_ROOT ?>contact",
                type: "POST",
                data: {
                    action: "send-message",
                    name: name,
                    email: email,
                    message: message,
                },
                success: function(response) {
                    if (response.success === true) {
                        $("#commentform")[0].reset();
                        // Display the error message on the page
                        $("#successMessage").text("Message Sent!").show();
                    }
                    // Set a timer to hide the error message after 3 seconds
                    setTimeout(function() {
                        $("#successMessage").fadeOut(); // Fade out the success message
                    }, 4000); // 3 seconds (3000 milliseconds)
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

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }
</script>
<?php $this->end() ?>