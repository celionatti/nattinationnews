<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** SiteController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;

use celionatti\Bolt\Bolt;
use PhpStrike\models\Users;
use PhpStrike\models\Articles;
use PhpStrike\models\Contacts;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Pagination\Pagination;

class SiteController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->currentUser = user();
    }

    public function welcome()
    {
        $view = [
            
        ];

        $this->view->render("articles/welcome", $view);
    }

    public function articles()
    {
        $view = [
            
        ];

        $this->view->render("articles/articles", $view);
    }

    public function category()
    {
        $view = [
            
        ];

        $this->view->render("articles/category", $view);
    }
}
