<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;

use celionatti\Bolt\Controller;

class AdminController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        // if (!hasAccess([], 'all', ['user', 'guest'])) {
        //     redirect("/", 401);
        // }
    }

    public function dashboard()
    {
        $view = [
            'title' => 'Dashboard',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => ''],
            ],
        ];

        $this->view->render("admin/dashboard", $view);
    }
}
