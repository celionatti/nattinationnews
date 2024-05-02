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
use PhpStrike\models\NattiPagination;

class SiteController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->currentUser = user();
    }

    public function welcome()
    {
        $articles = new Articles();

        $recentArticles = $articles->findAllByWithPagination(['status' => 'publish'], null, 15, "created_at", "desc");

        $editors_pick = $articles->getEditorsPick();

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($recentArticles['total'], $recentArticles['perPage'], $recentArticles['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT;

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'recentArticles' => $recentArticles['data'],
            'pagination' => $paginationLinks,
            'editorsPick' => $editors_pick,
        ];

        $this->view->render("articles/welcome", $view);
    }

    public function articles()
    {
        $view = [];

        $this->view->render("articles/articles", $view);
    }

    public function article(Request $request)
    {
        if ($request->isGet()) {
            $session = Bolt::$bolt->session;
            $id = $request->getParameter("id");
            $token = $request->getParameter("token");

            if ($session->get("viewed_article") !== $token) {
                $session->remove("viewed_article");
            }

            $articles = new Articles();

            if ($token && !$session->has("viewed_article") && $token !== $session->get("viewed_article")) {
                // Update the database to increase the views count
                $articles->increaseView($id);

                // User has not viewed this post before
                $session->set("viewed_article", $token);
            }

            $article = $articles->findOne(['status' => 'publish', 'article_id' => $id]);

            if (!$article) {
                toast("error", "Article Not Found!");
                redirect("/");
            }
        }

        $view = [
            'article' => $article,
        ];

        $this->view->render("articles/article", $view);
    }

    public function category()
    {
        $view = [];

        $this->view->render("articles/category", $view);
    }
}
