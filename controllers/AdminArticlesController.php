<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminArticlesController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;
use celionatti\Bolt\Bolt;

use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;

class AdminArticlesController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        // if (!hasAccess([], 'all', ['user', 'guest'])) {
        //     redirect("/", 401);
        // }
    }

    public function manage()
    {
        $view = [
            'title' => 'Manage Articles',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => ''],
            ],
        ];

        $this->view->render("admin/articles/manage", $view);
    }

    public function view_articles(Request $request)
    {
        return '';
    }

    public function create_article(Request $request)
    {
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'article' => retrieveSessionData('article_data'),
            'title' => 'Create Article',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Create Article', 'url' => ''],
            ],
            'statusOpts' => [
                'draft' => 'Draft',
                'publish' => 'Publish',
            ],
            'upload_type' => $request->get('ut'),
        ];

        $this->view->render("admin/articles/create", $view);
    }

    public function create(Request $request)
    {
        return '';
    }
}