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

        if (!hasAccess(['admin', 'manager', 'editor', 'journalist'], 'all', [])) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
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

    public function profile()
    {
        $view = [
            'title' => 'Profile',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Profile', 'url' => ''],
            ],
        ];

        $this->view->render("admin/profile", $view);
    }
}
