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

use OpenAI;

use celionatti\Bolt\Bolt;
use PhpStrike\models\Editor;
use PhpStrike\models\Regions;
use PhpStrike\models\Articles;
use PhpStrike\models\Comments;
use celionatti\Bolt\Controller;
use PhpStrike\models\Categories;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\Image;
use celionatti\Bolt\Helpers\Upload;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;

class AdminArticlesController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        $this->currentUser = user();

        if (is_null($this->currentUser)) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
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

    public function manage_drafts()
    {
        $view = [
            'title' => 'Manage Draft Articles',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Draft Articles', 'url' => ''],
            ],
        ];

        $this->view->render("admin/articles/drafts", $view);
    }

    public function create_article(Request $request)
    {
        $categories = new Categories();
        $regions = new Regions();

        $categorys = $categories->getCategories();
        $region = $regions->getRegions();

        $categoryOptions = ['none' => 'None'];
        foreach ($categorys as $category) {
            $categoryOptions[$category->category_id] = ucfirst($category->category);
        }

        $regionOptions = ['none' => 'None'];
        foreach ($region as $reg) {
            $regionOptions[$reg->region_id] = ucfirst($reg->region);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'article' => retrieveSessionData('article_data'),
            'title' => 'Create Article',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Create Article', 'url' => ''],
            ],
            'categoryOpts' => $categoryOptions,
            'regionOpts' => $regionOptions,
            'statusOpts' => [
                'draft' => 'Draft',
                'publish' => 'Publish',
            ],
            'upload_type' => $request->get('ut'),
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['article_data']);

        $this->view->render("admin/articles/create", $view);
    }

    public function create(Request $request)
    {
        $article = new Articles();

        $uploadType = $request->get("ut");

        if ($request->isPost()) {
            $article->fillable([
                "article_id",
                "user_id",
                "title",
                "category_id",
                "region_id",
                "content",
                "key_point",
                "tags",
                "thumbnail",
                "thumbnail_caption",
                "image",
                "image_caption",
                "authors",
                "status",
                "meta_title",
                "meta_description",
                "meta_keywords",
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['article_id'] = generateUuidV4();
            $data['user_id'] = $this->currentUser->user_id ?? null;
            $data['meta_title'] = generateMetaTitle($data['title']);
            $data['meta_description'] = generateMetaDescription($data['content']);
            $data['meta_keywords'] = generateKeywords($data['content']);
            $article->setIsInsertionScenario('create'); // Set insertion scenario flag
            $uploader = new Upload("uploads/articles");
            $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);
            if ($article->validate($data)) {
                if ($uploadType === "file") {
                    $thumbnail = $uploader->uploadFile('thumbnail');
                    $image = $uploader->uploadFile('image');

                    if (isset($thumbnail['error']) || !empty($thumbnail['thumbnail'])) {
                        FlashMessage::setMessage($thumbnail['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                    }
                    if (isset($image['error']) || !empty($image['image'])) {
                        FlashMessage::setMessage($image['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                    }

                    if ($thumbnail['success'] && $image['success']) {
                        $data['thumbnail'] = $thumbnail['path'];
                        $data['image'] = $image['path'];

                        $image = new Image();
                        $image->resize($data['thumbnail']);
                        $image->resize($data['image']);
                        $image->watermark($data['thumbnail'], "assets/img/natti.png");
                        $image->watermark($data['image'], "assets/img/natti.png");
                    }
                }

                if ($article->insert($data)) {
                    toast("success", "Article Created Successfully");
                    redirect(URL_ROOT . "admin/manage-articles");
                }
            } else {
                storeSessionData('article_data', $data);
            }
        }
        toast("error", "Article Creation Failed!");
        Bolt::$bolt->session->setFormMessage($article->getErrors());
        redirect("/admin/articles/create?ut={$uploadType}");
    }

    public function edit_article(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $article = $article->findOne([
            'article_id' => $id,
        ]);

        $categories = new Categories();
        $regions = new Regions();

        $categorys = $categories->getCategories();
        $region = $regions->getRegions();

        $categoryOptions = ['none' => 'None'];
        foreach ($categorys as $category) {
            $categoryOptions[$category->category_id] = ucfirst($category->category);
        }

        $regionOptions = ['none' => 'None'];
        foreach ($region as $reg) {
            $regionOptions[$reg->region_id] = ucfirst($reg->region);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'article' => $article ?? retrieveSessionData('article_data'),
            'title' => 'Edit Article',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Edit Article', 'url' => ''],
            ],
            'categoryOpts' => $categoryOptions,
            'regionOpts' => $regionOptions,
            'statusOpts' => [
                'draft' => 'Draft',
                'publish' => 'Publish',
            ],
            'upload_type' => $request->get('ut'),
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['article_data']);

        $this->view->render("admin/articles/edit", $view);
    }

    public function edit(Request $request)
    {
        $id = $request->getParameter("id");

        $uploadType = $request->get("ut");

        $article = new Articles();

        $a = $article->findOne([
            'article_id' => $id,
        ]);

        $roles = ["admin", "manager"];

        if (hasRole($this->currentUser, $roles) || isCurrentUser($this->currentUser, $a->user_id)) {
            if (!$a) {
                toast("info", "Article Not Found!");
                redirect("/admin/manage-articles");
            }

            if ($request->isPost()) {
                $article->updatable([
                    "user_id",
                    "title",
                    "category_id",
                    "region_id",
                    "content",
                    "key_point",
                    "tags",
                    "thumbnail",
                    "thumbnail_caption",
                    "image",
                    "image_caption",
                    "authors",
                    "status",
                    "meta_title",
                    "meta_description",
                    "meta_keywords",
                ]);
                $data = $request->getBody();
                validate_csrf_token($data);
                $data['thumbnail'] = $a->thumbnail;
                $data['image'] = $a->image;
                $data['user_id'] = $a->user_id;
                $data['meta_title'] = generateMetaTitle($data['title']);
                $data['meta_description'] = generateMetaDescription($data['content']);
                $data['meta_keywords'] = generateKeywords($data['content']);
                $article->setIsInsertionScenario('edit'); // Set insertion scenario flag
                $uploader = new Upload("uploads/articles");
                $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
                $uploader->setOverwriteExisting(true);
                if ($article->validate($data)) {
                    if ($uploadType === "file") {
                        if (!empty($_FILES['thumbnail']['name']) || !empty($_FILES['image']['name'])) {
                            $thumbnail = $uploader->uploadFile('thumbnail');
                            $image = $uploader->uploadFile('image');

                            if (isset($thumbnail['error']) || !empty($thumbnail['thumbnail'])) {
                                FlashMessage::setMessage($thumbnail['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                            }
                            if (isset($image['error']) || !empty($image['image'])) {
                                FlashMessage::setMessage($image['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                            }

                            if ($thumbnail['success'] && $image['success']) {
                                if ($a->thumbnail !== null || $a->image !== null) {
                                    $uploader->deleteFile($a->thumbnail);
                                    $uploader->deleteFile($a->image);
                                }
                                $data['thumbnail'] = $thumbnail['path'];
                                $data['image'] = $image['path'];

                                $image = new Image();
                                $image->resize($data['thumbnail']);
                                $image->resize($data['image']);
                                $image->watermark($data['thumbnail'], "assets/img/natti.png");
                                $image->watermark($data['image'], "assets/img/natti.png");
                            }
                        }
                    }

                    if ($article->updateBy($data, ['article_id' => $id])) {
                        toast("success", "Article Updated Successfully");
                        redirect(URL_ROOT . "admin/manage-articles");
                    }
                } else {
                    storeSessionData('article_data', $data);
                }
            }
            toast("info", "Nothing to Update - No changes made!");
            Bolt::$bolt->session->setFormMessage($article->getErrors());
            redirect("/admin/articles/edit/{$id}?ut={$uploadType}");
        }
        toast("info", "You dont have access to Update!");
        redirect("/admin/articles/edit/{$id}?ut={$uploadType}");
    }

    public function delete_article(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        $view = [
            'article' => $data,
            'title' => 'Delete Article',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Delete Article', 'url' => ''],
            ],
        ];

        $this->view->render("admin/articles/delete", $view);
    }

    public function delete(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);

            $id = $request->getParameter("id");
            $article = new Articles();

            $a = $article->findOne(['article_id' => $id]);

            $roles = ["admin", "manager"];

            if (hasRole($this->currentUser, $roles) || isCurrentUser($this->currentUser, $a->user_id)) {
                if (!$a) {
                    toast('info', "Article Not Found!");
                    redirect('/admin/manage-articles');
                }

                if ($a) {
                    unlink($a->thumbnail);
                    unlink($a->image);

                    if ($article->deleteBy(['article_id' => $id])) {
                        toast("success", "Article Deleted Successfully!");
                        redirect(URL_ROOT . "admin/manage-articles");
                    }
                }
                toast("info", "Failure on Deleting process!");
                redirect(URL_ROOT . "admin/manage-articles");
            }
            toast("info", "You dont have access to Update!");
            redirect(URL_ROOT . "admin/manage-articles");
        }
    }

    public function editors(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        if (!$data) {
            toast('info', "Article Not Found!");
            redirect('/admin/manage-articles');
        }

        $article->updatable(['is_editors_pick']);

        if ($article->updateBy(['is_editors_pick' => 'true'], ['article_id' => $id])) {
            toast('success', "Article Editors Picked!");
            redirect('/admin/manage-articles');
        }
        toast("error", "Article Update Editors Pick Failed!");
        redirect("/admin/manage-articles");
    }

    public function editors_pick()
    {
        $view = [
            'title' => 'Manage Editor Picks',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Manage Editor Picks', 'url' => ''],
            ],
        ];

        $this->view->render("admin/articles/editor-picks", $view);
    }

    public function remove_editor_pick(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        if (!$data) {
            toast('info', "Article Not Found!");
            redirect('/admin/articles/editor-picks');
        }

        $article->updatable(['is_editors_pick']);

        if ($article->updateBy(['is_editors_pick' => 'false'], ['article_id' => $id])) {
            toast('success', "Removed Editors Picked Successfully!");
            redirect('/admin/articles/editors-pick');
        }
        toast("error", "Article Update Editors Pick Failed!");
        redirect("/admin/articles/editors-pick");
    }

    public function featured_articles()
    {
        $view = [
            'title' => 'Manage Featured Articles',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Manage Featured Articles', 'url' => ''],
            ],
        ];

        $this->view->render("admin/articles/featured", $view);
    }

    public function featured(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        if (!$data) {
            toast('info', "Article Not Found!");
            redirect('/admin/manage-articles');
        }

        $article->updatable(['featured_article']);

        if ($article->updateBy(['featured_article' => 'true'], ['article_id' => $id])) {
            toast('success', "Article Added To Featured Articles!");
            redirect('/admin/manage-articles');
        }
        toast("info", "Article Featured Failed!");
        redirect("/admin/manage-articles");
    }

    public function remove_featured(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        if (!$data) {
            toast('info', "Article Not Found!");
            redirect('/admin/articles/featured-articles');
        }

        $article->updatable(['featured_article']);

        if ($article->updateBy(['featured_article' => 'false'], ['article_id' => $id])) {
            toast('success', "Removed Featured Article Successfully!");
            redirect('/admin/articles/featured-articles');
        }
        toast("error", "Article Featured Failed!");
        redirect("/admin/articles/featured-articles");
    }

    public function preview(Request $request)
    {
        $id = $request->getParameter("id");

        $article = new Articles();

        $data = $article->findOne([
            'article_id' => $id,
        ]);

        if (!$data) {
            toast("error", "Article Not Found");
            redirect('/admin/manage-articles');
        }

        $view = [
            'title' => 'Preview Article',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Preview Article', 'url' => ''],
            ],
            'article' => $data,
        ];

        $this->view->render("admin/articles/preview", $view);
    }

    public function view_articles(Request $request)
    {
        if ($request->isPost() && $request->post('action') === "view-articles") {
            $articles = new Articles();
            $data = $articles->findAllBy(['status' => 'publish']);

            if (empty($data)) {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }

            $output = $this->generateArticlesTable($data);
            $this->json_response($output);
        }
    }

    /** Draft Article */

    public function view_draft_articles(Request $request)
    {
        if ($request->isPost() && $request->post('action') === "view-draft-articles") {
            $articles = new Articles();
            $data = $articles->findAllBy(['status' => 'draft']);

            if (empty($data)) {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }

            $output = $this->generateArticlesTable($data);
            $this->json_response($output);
        }
    }

    /** Editors Articles */

    public function view_editors_pick(Request $request)
    {
        if ($request->isPost() && $request->post('action') === "editors-pick") {
            $articles = new Articles();
            $data = $articles->findAllBy(['is_editors_pick' => 'true']);

            if (empty($data)) {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }

            $output = $this->generateArticlesTable($data);
            $this->json_response($output);
        }
    }

    /** Featured Articles */

    public function view_featured_articles(Request $request)
    {
        if ($request->isPost() && $request->post('action') === "featured-articles") {
            $articles = new Articles();
            $data = $articles->findAllBy(['featured_article' => 'true']);

            if (empty($data)) {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }

            $output = $this->generateArticlesTable($data);
            $this->json_response($output);
        }
    }

    public function comments(Request $request)
    {
        $id = $request->getParameter("id");

        $comments = new Comments();

        $articleComments = $comments->findAllBy(['article_id' => $id]);

        $view = [
            'errors' => [],
            'title' => 'Article Comments',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Articles', 'url' => 'admin/manage-articles'],
                ['label' => 'Article Comments', 'url' => ''],
            ],
            'comments' => $articleComments,
        ];

        $this->view->render("admin/articles/comments", $view);
    }

    public function delete_comment(Request $request)
    {
        $id = $request->getParameter("id");

        $comments = new Comments();

        $comment = $comments->findOne(['comment_id' => $id]);

        if (!$comment) {
            toast("info", "Comment Not Found!");
            redirect(URL_ROOT . "admin/manage-articles");
        }

        if ($comments->deleteBy(['comment_id' => $id])) {
            toast("success", "Comment Deleted Successfully!");
            redirect(URL_ROOT . "admin/articles/comments/{$comment->article_id}");
        }
    }

    public function upload_image(Request $request)
    {
        if ($request->isPost()) {
            $uploader = new Upload("uploads/articles/incl");
            $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            $file = $uploader->uploadFile('file');

            if (isset($file['error']) || !empty($file['file'])) {
                FlashMessage::setMessage($file['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
            }

            if ($file['success']) {
                $data['file'] = $file['path'];

                $image = new Image();
                $image->resize($data['file']);
                $image->watermark($data['file'], "assets/img/natti.png");

                $this->json_response($file['path']);
            }
        }
    }

    public function delete_image(Request $request)
    {
        if ($request->isPost()) {
            $imageUrl = $_POST['imageUrl'];

            if (file_exists($imageUrl)) {
                unlink($imageUrl);
                echo 'Image deleted successfully.';
            } else {
                echo 'Image not found or could not be deleted.';
            }
        }
    }

    private function generateArticlesTable($data)
    {
        $output = '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Title</th>
                        <th>View</th>
                        <th>Comments</th>
                        <th>Thumbnail</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $key => $row) {
            $output .= $this->generateArticleRow($key, $row);
        }

        $output .= '</tbody></table>';
        return $output;
    }

    private function generateArticleRow($key, $row)
    {
        $thumbnailSrc = get_image($row->thumbnail);
        $imageSrc = get_image($row->image);
        $status = statusVerification($row->status);
        $previewUrl = URL_ROOT . "admin/articles/preview/{$row->article_id}";
        $commentsUrl = URL_ROOT . "admin/articles/comments/{$row->article_id}";
        $editUrl = URL_ROOT . "admin/articles/edit/{$row->article_id}?ut=file";
        // Check if the article is already an editor's pick or featured article and update the URL accordingly
        if ($row->is_editors_pick === "true") {
            $editorPickUrl = URL_ROOT . "admin/articles/remove-editors-pick/{$row->article_id}";
        } else {
            $editorPickUrl = URL_ROOT . "admin/articles/editors/{$row->article_id}";
        }

        if ($row->featured_article === "true") {
            $featuredUrl = URL_ROOT . "admin/articles/remove-featured/{$row->article_id}";
        } else {
            $featuredUrl = URL_ROOT . "admin/articles/featured/{$row->article_id}";
        }
        $deleteUrl = URL_ROOT . "admin/articles/delete/{$row->article_id}";
        $editorPickStatus = $row->is_editors_pick === "true" ? "warning" : "success";
        $editorPickIcon = $row->is_editors_pick === "true" ? "<i class='fa-solid fa-minus'></i>" : "<i class='fa-solid fa-plus'></i>";
        $featuredStatus = $row->featured_article === "true" ? "secondary" : "success";
        $featuredStatusIcon = $row->featured_article === "true" ? "<i class='fa-solid fa-minus'></i>" : "<i class='fa-solid fa-plus'></i>";

        return "
        <tr class='text-center text-secondary'>
            <td>" . ($key + 1) . "</td>
            <td class='text-capitalize'><a href='{$previewUrl}' class='text-dark'>{$row->title}</a></td>
            <td class='text-capitalize fw-bold text-success'>{$row->views}</td>
            <td class='text-capitalize'><a href='{$commentsUrl}' title='Article Comments' class='btn btn-sm btn-outline-secondary px-3 py-1'><i class='bi bi-chat-left-text'></i></a></td>
            <td><img src='{$thumbnailSrc}' class='d-block' style='height:50px;width:50px;object-fit:cover;border-radius: 10px;cursor: pointer;'></td>
            <td><img src='{$imageSrc}' class='d-block' style='height:50px;width:50px;object-fit:cover;border-radius: 10px;cursor: pointer;'></td>
            <td class='text-capitalize'>{$status}</td>
            <td>
                <a href='{$editUrl}' title='Edit Article' class='btn btn-sm btn-outline-primary px-3 py-1 my-1'><i class='bi bi-pencil-square'></i></a>
                <a href='{$editorPickUrl}' title='Editor Pick' class='btn btn-sm btn-outline-{$editorPickStatus} px-3 py-1 my-1'>{$editorPickIcon} <i class='bi bi-patch-check'></i></a>
                <a href='{$featuredUrl}' title='Featured Article' class='btn btn-sm btn-outline-{$featuredStatus} px-3 py-1 my-1'>{$featuredStatusIcon} <i class='bi bi-stickies'></i></a>
                <a href='{$deleteUrl}' title='Delete Article' class='btn btn-sm btn-outline-danger px-3 py-1 my-1'><i class='bi bi-trash'></i></a>
            </td>
        </tr>";
    }

    private function access(array $data)
    {
        if (!hasAccess($data, 'all', [])) {
            toast("info", "PERMISSION NOT GRANTED!");
            redirect(URL_ROOT . "admin", 401);
        }
    }
}
