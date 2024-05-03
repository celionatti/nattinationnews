<?php

declare(strict_types=1);

/**
 * Framework: PhpStrike
 * Author: Celio Natti
 * version: 1.0.0
 * Year: 2023
 * 
 * Description: This file is for global constants
 */


const MAILER_EMAIL = "";
const MAILER_PASSWORD = "";
const MAILER_HOST = "smtp.gmail.com";

if (!defined('TWITTER_CLIENT_ID')) {
    define('TWITTER_CLIENT_ID', $_ENV["TWITTER_CLIENT_ID"] ?? "");
}

if (!defined('TWITTER_SECRET_ID')) {
    define('TWITTER_SECRET_ID', $_ENV["TWITTER_SECRET_ID"] ?? "");
}

if (!defined('OPEN_API_KEY')) {
    define('OPEN_API_KEY', $_ENV["OPEN_API_KEY"] ?? "");
}

if (!defined('FACEBOOK_LINK')) {
    define('FACEBOOK_LINK', $_ENV["FACEBOOK_LINK"] ?? "");
}

if (!defined('X_LINK')) {
    define('X_LINK', $_ENV["X_LINK"] ?? "");
}

if (!defined('YOUTUBE_LINK')) {
    define('YOUTUBE_LINK', $_ENV["YOUTUBE_LINK"] ?? "");
}

const ALLOWED_IMAGE_FILE_UPLOAD = ['image/png', 'image/jpg', 'image/jpeg'];

const ACCESSRULES = [
    'all'    => ['admin', 'user', 'author', 'editor', 'manager', 'guest'],
    'create' => ['admin', 'author', 'editor', 'manager'],
    'view'   => ['admin', 'author', 'editor', 'manager'],
    'edit'   => ['admin', 'author', 'editor', 'manager'],
    'delete' => ['admin', 'author', 'editor', 'manager'],
    'opt_one' => ['admin'],
    'opt_two' => ['admin', 'manager'],
    // Add more actions and roles as needed
];

const FILTER_TEXT = ['fuck'];

const PAYSTACK_PUBLIC_KEY = "pk_test_43ee004ce84d296f1a486d3b857fc55bb27ba43f";
