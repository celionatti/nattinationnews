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

use PhpStrike\models\Regions;
use PhpStrike\models\Articles;
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

    public function manage_drafts()
    {
        $view = [
            'title' => 'Manage Draft Articles',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Draft Articles', 'url' => ''],
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
            $data['user_id'] = $this->currentUser->user_id;
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
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-articles") {
                $output = '';
                $articles = new Articles();

                $data = $articles->findAllBy(['status' => 'publish']);

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>View</th>
                        <th>Authors</th>
                        <th>Thumbnail</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize">' . $row->title . '</td>
                    <td class="text-capitalize"><a href="' . URL_ROOT . "admin/articles/preview/{$row->article_id}" . '" title="View Article" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                    <td class="text-capitalize fw-bold text-success">' . $row->views . '</td>
                    <td class="text-capitalize">' . $row->authors . '</td>
                    <td><img src="' . get_image($row->thumbnail) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td><img src="' . get_image($row->image) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/articles/edit/{$row->article_id}?ut=file" . '" title="Edit Article" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/articles/editors/{$row->article_id}" . '" title="Editor Pick" class="btn btn-sm btn-outline-warning"><i class="bi bi-patch-check"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/articles/delete/{$row->article_id}" . '" title="Delete Article" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }
        }
    }

    public function view_draft_articles(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-draft-articles") {
                $output = '';
                $articles = new Articles();

                $data = $articles->findAllBy(['status' => 'draft']);

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>View</th>
                        <th>Authors</th>
                        <th>Thumbnail</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize">' . $row->title . '</td>
                    <td class="text-capitalize"><a href="' . URL_ROOT . "admin/articles/preview/{$row->article_id}" . '" title="View Article" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                    <td class="text-capitalize fw-bold text-success">' . $row->views . '</td>
                    <td class="text-capitalize">' . $row->authors . '</td>
                    <td><img src="' . get_image($row->thumbnail) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td><img src="' . get_image($row->image) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/articles/edit/{$row->article_id}?ut=file" . '" title="Edit Article" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/articles/editors/{$row->article_id}" . '" title="Editor Pick" class="btn btn-sm btn-outline-warning"><i class="bi bi-patch-check"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/articles/delete/{$row->article_id}" . '" title="Delete Article" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }
        }
    }

    public function view_editors_pick(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "editors-pick") {
                $output = '';
                $articles = new Articles();

                $data = $articles->findAllBy(['is_editors_pick' => 'true']);

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>View</th>
                        <th>Authors</th>
                        <th>Thumbnail</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize">' . $row->title . '</td>
                    <td class="text-capitalize"><a href="' . URL_ROOT . "admin/articles/preview/{$row->article_id}" . '" title="View Article" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                    <td class="text-capitalize fw-bold text-success">' . $row->views . '</td>
                    <td>' . $row->authors . '</td>
                    <td><img src="' . get_image($row->thumbnail) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td><img src="' . get_image($row->image) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/articles/edit/{$row->article_id}" . '" title="Edit Article" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/articles/remove-editor-pick/{$row->article_id}" . '" title="Editor Pick" class="btn btn-sm btn-outline-secondary"><i class="bi bi-dash-circle-dotted"></i></a>&nbsp;&nbsp;
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No editor present in the database!</h3>';
            }
        }
    }
}
