<?php

declare(strict_types=1);

use celionatti\Bolt\Bolt;
use PhpStrike\controllers\AuthController;
use PhpStrike\controllers\SiteController;
use PhpStrike\controllers\AdminController;
use PhpStrike\controllers\OthersController;
use PhpStrike\controllers\CommentController;
use PhpStrike\controllers\ProfileController;
use PhpStrike\controllers\AdminUsersController;
use PhpStrike\controllers\AdminOthersController;
use PhpStrike\controllers\AdminArticlesController;
use PhpStrike\controllers\AdminCommentsController;
use PhpStrike\controllers\AdminSettingsController;
use PhpStrike\controllers\AdminCategoriesController;

/** @var Bolt $bolt */

/**
 * ========================================
 * Bolt - Router Usage ====================
 * ========================================
 */

// $bolt->router->get("/user", function() {
//     echo "User function routing...";
// });

$bolt->router->get("/", [SiteController::class, "welcome"]);
$bolt->router->get("/articles", [SiteController::class, "articles"]);
$bolt->router->get("/category", [SiteController::class, "category"]);


/** Auth Method */

$bolt->router->get("/login", [AuthController::class, "login_view"]);
$bolt->router->post("/login", [AuthController::class, "login"]);
$bolt->router->get("/signup", [AuthController::class, "signup_view"]);
$bolt->router->post("/signup", [AuthController::class, "signup"]);
$bolt->router->get("/logout", [AuthController::class, "logout"]);
$bolt->router->get("/forgot-password", [AuthController::class, "forgot_view"]);
$bolt->router->post("/forgot-password", [AuthController::class, "forgot"]);



/**
 * Admin Section
 * 
 */

$bolt->router->get("/admin", [AdminController::class, "dashboard"]);

/** Categories */
$bolt->router->get("/admin/manage-categories", [AdminCategoriesController::class, "manage"]);
$bolt->router->post("/admin/create-categories", [AdminCategoriesController::class, "create"]);
$bolt->router->post("/admin/view-categories", [AdminCategoriesController::class, "view"]);

/** Articles */
$bolt->router->get("/admin/manage-articles", [AdminArticlesController::class, "manage"]);
$bolt->router->post("/admin/view-articles", [AdminArticlesController::class, "view_articles"]);
$bolt->router->get("/admin/articles/create", [AdminArticlesController::class, "create_article"]);
$bolt->router->post("/admin/articles/create", [AdminArticlesController::class, "create"]);