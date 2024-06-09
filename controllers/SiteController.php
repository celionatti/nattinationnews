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
use PhpStrike\models\Categories;
use PhpStrike\models\Users;
use PhpStrike\models\Articles;
use PhpStrike\models\Comments;
use PhpStrike\models\Contacts;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Http\Response;
use PhpStrike\models\NattiPagination;
use celionatti\Bolt\Pagination\Pagination;
use PhpStrike\models\Regions;

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

        $featuredArticles = $articles->getFeaturedArticles();

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
            'featuredArticles' => $featuredArticles,
        ];

        $this->view->render("articles/welcome", $view);
    }

    public function articles()
    {
        $articles = new Articles();

        $all_articles = $articles->findAllByWithPagination(['status' => 'publish'], null, 15, "created_at", "desc");

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($all_articles['total'], $all_articles['perPage'], $all_articles['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT . "articles";

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'articles' => $all_articles['data'],
            'pagination' => $paginationLinks,
        ];

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

            $recentArticles = $articles->getRecentArticles(5);

            if (!$article) {
                toast("error", "Article Not Found!");
                redirect("/");
            }
        }

        $view = [
            'article' => $article,
            'recents' => $recentArticles,
        ];

        $this->view->render("articles/article", $view);
    }

    public function article_comments(Request $request)
    {
        if ($request->isPost()) {

            $comments = new Comments();

            /**Load Comments */
            if ($request->post("action") && $request->post("action") === "load_comments") {
                $article_id = $request->post("article_id");
                $article_url = $request->post("article_url");
                $output = "";

                $data = $comments->findAllByWithPagination(['status' => 'active', 'article_id' => $article_id], null, 10, "created_at", "desc");

                // Create a CustomPaginator instance
                $paginator = new NattiPagination($data['total'], $data['perPage'], $data['page']);

                // Get the current URL (you may need to adjust this based on your framework)
                $currentUrl = $article_url;

                // Generate pagination links
                $paginationLinks = $paginator->generateCommentLinks($currentUrl);

                $output .= '<div class="comments-title">';
                $output .= '<p>There are ' . $data['total'] . ' comments for this article</p>';
                $output .= '</div>';


                if ($data['data']) {
                    $output .= '<ol class="commentlist">';

                    foreach ($data['data'] as $key => $row) {
                        if (!isset($row->reply_id)) {
                            $output .= '<li id="li-comment">';
                            $output .= '<article class="comment even thread-even depth-1 clr" id="comment-' . $row->id . '">';
                            $output .= '<div class="comment-author vcard">';
                            $output .= '<img width="60" height="60" src="' . get_image("", "avatar") . '" alt="">';
                            $output .= '</div>';
                            $output .= '<div class="comment-details clr">';
                            $output .= '<header class="comment-meta">';
                            $output .= '<strong class="fn me-2">' . $row->name . '</strong>';
                            $output .= '<span class="comment-date">' . date("F j, Y g:i a", strtotime($row->created_at)) . '</span>';
                            $output .= '</header>';
                            $output .= '<div class="comment-content entry clr">';
                            $output .= '<p>' . htmlspecialchars($row->comment_text) . '</p>'; // Ensure content is properly escaped
                            $output .= '</div>';
                            $output .= '<div class="reply comment-reply-link-div">';
                            $output .= '<button type="button" value="' . $row->comment_id . '" data-comment-name="' . $row->name . '" class="reply_btn border border-dark border-2 btn btn-sm" id="respond">Reply</button>';
                            $output .= '</div>';
                            $output .= '</article>';
                        }

                        // Find and include replies for this parent comment
                        $replies = $comments->findReplies($article_id, $row->comment_id);
                        if ($replies) {
                            $output .= '<ul class="children">';
                            foreach ($replies as $reply) {
                                $output .= '<li id="li-comment-' . $reply->id . '">';
                                $output .= '<article class="comment odd alt depth-2 clr" id="comment-' . $reply->id . '">';
                                $output .= '<div class="comment-author vcard">';
                                $output .= '<img width="60" height="60" src="' . get_image("", "avatar") . '" alt="">';
                                $output .= '</div>';
                                $output .= '<div class="comment-details clr">';
                                $output .= '<header class="comment-meta">';
                                $output .= '<strong class="fn me-2">' . $reply->name . '</strong>';
                                $output .= '<span class="comment-date">' . date("F j, Y g:i a", strtotime($reply->created_at)) . '</span>';
                                $output .= '</header>';
                                $output .= '<div class="comment-content entry clr">';
                                $output .= '<p>' . htmlspecialchars($reply->comment_text) . '</p>'; // Ensure content is properly escaped
                                $output .= '</div>';
                                $output .= '</div>';
                                $output .= '</article>';
                                $output .= '</li>';
                            }
                            $output .= '</ul>';
                        }

                        $output .= '</li>';
                    }

                    $output .= '</ol>';
                    $output .= $paginationLinks;
                } else {
                    $output .= '<h4 class="text-center my-3">No Comment yet!</h4>';
                }
                $this->json_response($output);
            }

            /**Create Comment */
            if ($request->post("action") && $request->post("action") === "create_comment") {
                $name = $request->post("name");
                $comment_text = $request->post("comment_text");
                $reply_id = $request->post("reply_id");
                $article_id = $request->post("article_id");
                if (empty($comment_text)) {
                    $this->json_error_response("Comment Message cannot be empty", Response::FORBIDDEN);
                    exit;
                }

                if (!empty($comment_text)) {
                    if (empty($name) || is_null($name) || $name == "") {
                        $name = "@anonymous";
                    }
                    if (empty($reply_id)) {
                        $reply_id = null;
                    }

                    $comments->fillable([
                        'comment_id',
                        'article_id',
                        'reply_id',
                        'name',
                        'comment_text',
                        'status',
                        'failure_reason',
                    ]);
                    $data = $request->getBody();
                    $filterText = filterText($data['comment_text'], FILTER_TEXT);

                    $data['comment_id'] = generateUuidV4();
                    $data['article_id'] = $article_id;
                    $data['name'] = $name;
                    $data['reply_id'] = $reply_id;
                    if ($filterText) {
                        $data['status'] = "pending";
                        $data['failure_reason'] = "Message Contains Filtered words";
                    } else {
                        $data['status'] = "active";
                    }
                    $comments->setIsInsertionScenario('create'); // Set insertion scenario flag

                    if ($comments->validate($data)) {
                        if ($comments->insert($data)) {
                            $this->json_response("Comment Added Successfully", Response::CREATED);
                        }
                    } else {
                        $this->json_error_response("Error Occur, Try Again Later!", Response::NOT_MODIFIED);
                        exit;
                    }
                }
            }
        }
    }

    public function search(Request $request)
    {
        if ($request->isGet()) {
            $search = $request->get("search");

            $articles = new Articles();

            $articleSearch = $articles->rawQueryPagination(['status' => 'publish'], "SELECT * FROM articles WHERE title LIKE '%$search%' OR tags LIKE '%$search%' OR content LIKE '%$search%' AND status = :status", ['status' => 'publish'], null, 10, "created_at");

            // Create a CustomPaginator instance
            $paginator = new NattiPagination($articleSearch['total'], $articleSearch['perPage'], $articleSearch['page']);

            // Get the current URL (you may need to adjust this based on your framework)
            $currentUrl = URL_ROOT . "search?search={$search}";

            // Generate pagination links
            $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);
        }

        $view = [
            'articles' => $articleSearch['data'],
            'total' => count($articleSearch['data']),
            'search' => $search,
            'pagination' => $paginationLinks,
        ];

        $this->view->render("articles/search", $view);
    }

    public function category(Request $request)
    {
        $id = $request->getParameter("id");
        $name = $request->getParameter("name");

        $articles = new Articles();

        $categoryModel = new Categories();

        $categories = $articles->findAllByWithPagination(['category_id' => $id, 'status' => 'publish'], null, 15, "created_at", "desc");

        $categoryDetails = $categoryModel->findOne(['category_id' => $id]);

        if (!$categories) {
            toast("info", "Category Not Found!.");
            redirect(URL_ROOT);
        }

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($categories['total'], $categories['perPage'], $categories['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT . "categories/{$name}/{$id}";

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'categories' => $categories['data'],
            'pagination' => $paginationLinks,
            'categoryDetails' => $categoryDetails,
        ];

        $this->view->render("articles/category", $view);
    }

    public function region(Request $request)
    {
        $id = $request->getParameter("id");
        $name = $request->getParameter("name");

        $articles = new Articles();

        $regionModel = new Regions();

        $regions = $articles->findAllByWithPagination(['region_id' => $id, 'status' => 'publish'], null, 15, "created_at", "desc");

        $regionDetails = $regionModel->findOne(['region_id' => $id]);

        if (!$regions) {
            toast("info", "Region Not Found!.");
            redirect(URL_ROOT);
        }

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($regions['total'], $regions['perPage'], $regions['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT . "region/{$name}/{$id}";

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'regions' => $regions['data'],
            'pagination' => $paginationLinks,
            'regionDetails' => $regionDetails,
        ];

        $this->view->render("articles/region", $view);
    }

    public function article_tags(Request $request)
    {
        $tag = $request->getParameter("tag");

        $articles = new Articles();

        $article = $articles->rawQueryPagination(['status' => 'publish'], "SELECT * FROM articles WHERE tags LIKE '%$tag%' AND status = :status", ['status' => 'publish'], null, 10, "created_at");

        if (!$article) {
            toast("info", "Article Not Found!.");
            redirect(URL_ROOT);
        }

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($article['total'], $article['perPage'], $article['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT . "article-tags/{$tag}";

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'articles' => $article['data'],
            'pagination' => $paginationLinks,
            'tag' => $tag,
        ];

        $this->view->render("articles/tags", $view);
    }

    public function author(Request $request)
    {
        $author_id = $request->getParameter("id");

        $articles = new Articles();
        $users = new Users();

        $article = $articles->rawQueryPagination(['status' => 'publish'], "SELECT a.*, u.surname FROM articles a LEFT JOIN users u ON a.user_id = u.user_id WHERE a.status = :status AND a.user_id = :user_id", ['status' => 'publish', 'user_id' => $author_id], null, 10, "created_at");

        $user = $users->findOne(['user_id' => $author_id]);

        if (!$user) {
            toast("info", "User Not Found!.");
            redirect(URL_ROOT);
        }

        if (!$article) {
            toast("info", "Article Not Found!.");
            redirect(URL_ROOT);
        }

        // Create a CustomPaginator instance
        $paginator = new NattiPagination($article['total'], $article['perPage'], $article['page']);

        // Get the current URL (you may need to adjust this based on your framework)
        $currentUrl = URL_ROOT . "author/{$author_id}";

        // Generate pagination links
        $paginationLinks = $paginator->generateBootstrapDefLinks($currentUrl);

        $view = [
            'user' => $user,
            'articles' => $article['data'],
            'pagination' => $paginationLinks,
        ];

        $this->view->render("articles/author", $view);
    }

    public function contact(Request $request)
    {
        $view = [];

        $this->view->render("articles/contact", $view);
    }

    public function send_message(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "send-message") {
                $name = $request->post("name");
                $email = $request->post("email");
                $message = $request->post("message");
                if (empty($name) || empty($email) || empty($message)) {
                    http_response_code(400); // Bad Request
                    echo json_encode(['error' => 'All field are Required!']);
                    exit;
                }

                $data = [];

                $contacts = new Contacts();

                $contacts->fillable([
                    'contact_id',
                    'name',
                    'email',
                    'message',
                ]);

                $data['contact_id'] = generateUuidV4();
                $data['name'] = $name;
                $data['email'] = $email;
                $data['message'] = $message;

                $contacts->setIsInsertionScenario("create");

                if ($contacts->validate($data)) {
                    if ($contacts->insert($data)) {
                        $this->json_response(['message' => 'Message Sent Successfully!', 'success' => true]);
                    }
                } else {
                    storeSessionData('contact_data', $data);
                }
            }
        }
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Something went wrong!']);
    }

    public function privacy_policy(Request $request)
    {
        $view = [];

        $this->view->render("articles/privacy_policy", $view);
    }

    public function terms_conditions(Request $request)
    {
        $view = [];

        $this->view->render("articles/terms_conditions", $view);
    }
}
