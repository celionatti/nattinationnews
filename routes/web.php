<?php

declare(strict_types=1);

use celionatti\Bolt\Bolt;
use PhpStrike\controllers\SiteController;
use PhpStrike\controllers\AdminController;
use PhpStrike\controllers\OthersController;
use PhpStrike\controllers\CommentController;
use PhpStrike\controllers\ProfileController;
use PhpStrike\controllers\AdminAuthController;
use PhpStrike\controllers\AdminUsersController;
use PhpStrike\controllers\AdminOthersController;
use PhpStrike\controllers\AdminRegionsController;
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
$bolt->router->get("/article/{id}/{token}", [SiteController::class, "article"]);
$bolt->router->post("/article/{id}/{token}", [SiteController::class, "article_comments"]);
$bolt->router->get("/search", [SiteController::class, "search"]);
$bolt->router->get("/categories/{name}/{id}", [SiteController::class, "category"]);
$bolt->router->get("/region/{name}/{id}", [SiteController::class, "region"]);
$bolt->router->get("/article-tags/{tag}", [SiteController::class, "article_tags"]);
$bolt->router->get("/author/{id}", [SiteController::class, "author"]);
$bolt->router->get("/contact", [SiteController::class, "contact"]);
$bolt->router->post("/contact", [SiteController::class, "send_message"]);



/**
 * Admin Section
 * 
 */

$bolt->router->get("/admin", [AdminController::class, "dashboard"]);
$bolt->router->get("/admin/profile", [AdminController::class, "profile"]);
$bolt->router->post("/admin/profile", [AdminController::class, "update_profile"]);
$bolt->router->get("/admin/change-password", [AdminController::class, "password"]);
$bolt->router->post("/admin/change-password", [AdminController::class, "change_password"]);
$bolt->router->get("/admin/delete-profile", [AdminController::class, "delete_profile"]);
$bolt->router->post("/admin/delete-profile", [AdminController::class, "delete"]);

$bolt->router->get("/dashboard/login", [AdminAuthController::class, "login_view"]);
$bolt->router->post("/dashboard/login", [AdminAuthController::class, "login"]);

$bolt->router->get("/logout", [AdminAuthController::class, "logout"]);

/** Users */
$bolt->router->get("/admin/manage-users", [AdminUsersController::class, "manage"]);
$bolt->router->post("/admin/view-users", [AdminUsersController::class, "view"]);
$bolt->router->get("/admin/users/create", [AdminUsersController::class, "create_user"]);
$bolt->router->post("/admin/users/create", [AdminUsersController::class, "create"]);
$bolt->router->get("/admin/users/edit/{id}", [AdminUsersController::class, "edit_user"]);
$bolt->router->post("/admin/users/edit/{id}", [AdminUsersController::class, "edit"]);
$bolt->router->get("/admin/users/delete/{id}", [AdminUsersController::class, "delete_user"]);
$bolt->router->post("/admin/users/delete/{id}", [AdminUsersController::class, "delete"]);

$bolt->router->get("/verify-user/{id}", [AdminUsersController::class, "verify_user"]);
$bolt->router->get("/unverify-user/{id}", [AdminUsersController::class, "unverify_user"]);
$bolt->router->get("/block-user/{id}", [AdminUsersController::class, "block_user"]);
$bolt->router->get("/unblock-user/{id}", [AdminUsersController::class, "unblock_user"]);

/** Categories */
$bolt->router->get("/admin/manage-categories", [AdminCategoriesController::class, "manage"]);
$bolt->router->get("/admin/categories/create", [AdminCategoriesController::class, "create_category"]);
$bolt->router->post("/admin/categories/create", [AdminCategoriesController::class, "create"]);
$bolt->router->post("/admin/view-categories", [AdminCategoriesController::class, "view"]);
$bolt->router->get("/admin/categories/edit/{id}", [AdminCategoriesController::class, "edit_category"]);
$bolt->router->post("/admin/categories/edit/{id}", [AdminCategoriesController::class, "edit"]);
$bolt->router->get("/admin/categories/delete/{id}", [AdminCategoriesController::class, "delete_category"]);
$bolt->router->post("/admin/categories/delete/{id}", [AdminCategoriesController::class, "delete"]);

/** Regions */
$bolt->router->get("/admin/manage-regions", [AdminRegionsController::class, "manage"]);
$bolt->router->get("/admin/regions/create", [AdminRegionsController::class, "create_region"]);
$bolt->router->post("/admin/regions/create", [AdminRegionsController::class, "create"]);
$bolt->router->post("/admin/view-regions", [AdminRegionsController::class, "view"]);
$bolt->router->get("/admin/regions/edit/{id}", [AdminRegionsController::class, "edit_region"]);
$bolt->router->post("/admin/regions/edit/{id}", [AdminRegionsController::class, "edit"]);
$bolt->router->get("/admin/regions/delete/{id}", [AdminRegionsController::class, "delete_region"]);
$bolt->router->post("/admin/regions/delete/{id}", [AdminRegionsController::class, "delete"]);

/** Articles */
$bolt->router->get("/admin/manage-articles", [AdminArticlesController::class, "manage"]);
$bolt->router->get("/admin/articles/drafts", [AdminArticlesController::class, "manage_drafts"]);
$bolt->router->post("/admin/view-articles", [AdminArticlesController::class, "view_articles"]);
$bolt->router->post("/admin/view-draft-articles", [AdminArticlesController::class, "view_draft_articles"]);
$bolt->router->get("/admin/articles/create", [AdminArticlesController::class, "create_article"]);
$bolt->router->post("/admin/articles/create", [AdminArticlesController::class, "create"]);
$bolt->router->get("/admin/articles/edit/{id}", [AdminArticlesController::class, "edit_article"]);
$bolt->router->post("/admin/articles/edit/{id}", [AdminArticlesController::class, "edit"]);
$bolt->router->get("/admin/articles/delete/{id}", [AdminArticlesController::class, "delete_article"]);
$bolt->router->post("/admin/articles/delete/{id}", [AdminArticlesController::class, "delete"]);
$bolt->router->post("/editor-upload-image", [AdminArticlesController::class, "upload_image"]);
$bolt->router->post("/delete-editor-image", [AdminArticlesController::class, "delete_image"]);

$bolt->router->get("/admin/articles/preview/{id}", [AdminArticlesController::class, "preview"]);

$bolt->router->get("/admin/articles/editors/{id}", [AdminArticlesController::class, "editors"]);
$bolt->router->get("/admin/articles/editors-pick", [AdminArticlesController::class, "editors_pick"]);
$bolt->router->get("/admin/articles/remove-editor-pick/{id}", [AdminArticlesController::class, "remove_editor_pick"]);
$bolt->router->post("/admin/articles/view-editors-pick", [AdminArticlesController::class, "view_editors_pick"]);

$bolt->router->get("/admin/articles/featured-articles", [AdminArticlesController::class, "featured_articles"]);
$bolt->router->get("/admin/articles/featured/{id}", [AdminArticlesController::class, "featured"]);
$bolt->router->get("/admin/articles/remove-featured/{id}", [AdminArticlesController::class, "remove_featured"]);
$bolt->router->post("/admin/articles/view-featured-articles", [AdminArticlesController::class, "view_featured_articles"]);
$bolt->router->get("/admin/articles/ai-article", [AdminArticlesController::class, "ai_article"]);
$bolt->router->post("/admin/articles/view-ai-article", [AdminArticlesController::class, "view_ai_article"]);

$bolt->router->get("/admin/articles/comments/{id}", [AdminArticlesController::class, "comments"]);
$bolt->router->post("/admin/articles/comments/{id}", [AdminArticlesController::class, "view_comments"]);