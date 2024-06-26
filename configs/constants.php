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


date_default_timezone_set("Africa/Lagos");

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

const ALLOWED_IMAGE_FILE_UPLOAD = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/svg+xml', 'image/webp', 'image/x-icon'];

const ALLOWED_DOC_FILE_UPLOAD = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'text/plain'];

const ALLOWED_ARCHIVE_FILE_UPLOAD = ['application/zip', 'application/x-tar', 'application/gzip', 'application/x-rar-compressed'];
const ALLOWED_FONT_FILE_UPLOAD = ['font/woff', 'font/woff2', 'application/x-font-ttf', 'application/x-font-opentype'];
const ALLOWED_VIDEO_FILE_UPLOAD = ['video/mp4', 'video/webm', 'video/ogg'];
const ALLOWED_AUDIO_FILE_UPLOAD = ['audio/mpeg', 'audio/ogg', 'audio/wav'];

const FILTER_TEXT = ['fuck'];

const PAYSTACK_PUBLIC_KEY = "pk_test_43ee004ce84d296f1a486d3b857fc55bb27ba43f";
