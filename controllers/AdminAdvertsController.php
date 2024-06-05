<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminAdvertsController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;


use celionatti\Bolt\Bolt;
use PhpStrike\models\Settings;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\Image;
use celionatti\Bolt\Helpers\Upload;
use PhpStrike\models\Advertisements;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;

class AdminAdvertsController extends Controller
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
            'title' => 'Manage Advertisement',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Advertisement', 'url' => ''],
            ],
        ];

        $this->view->render("admin/adverts/manage", $view);
    }

    public function view_adverts(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-adverts") {
                $output = '';
                $advertisements = new Advertisements();

                $data = $advertisements->findAll();

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Image</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize">' . $row->name . '</td>
                    <td class="text-dark">' . $row->link . '</td>
                    <td><img src="' . get_image($row->advert_img) . '" class="d-block" style="height:50px;width:60px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . statusVerification($row->priority) . '</td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>>
                    <td>
                    <a href="' . URL_ROOT . "admin/advertisements/edit/{$row->advert_id}?ut=file" . '" title="Edit Advertisement" class="btn btn-sm btn-outline-primary px-3 py-1 my-1"><i class="bi bi-pencil-square"></i></a>

                    <a href="' . URL_ROOT . "admin/advertisements/delete/{$row->advert_id}" . '" title="Delete Advertisement" class="btn btn-sm btn-outline-danger px-3 py-1 my-1"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No advertisement present in the database!</h3>';
            }
        }
    }

    public function create_advert(Request $request)
    {
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'advert' => retrieveSessionData('advert_data'),
            'title' => 'Create Advertisement',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Advertisements', 'url' => 'admin/manage-advertisements'],
                ['label' => 'Create Advertisement', 'url' => ''],
            ],
            'priorityOpts' => [
                'none' => 'None',
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
                'banner' => 'Banner*',
            ],
            'statusOpts' => [
                'pending' => 'Pending',
                'open' => 'Open',
                'closed' => 'Closed',
                'expired' => 'Expired',
            ],
            'upload_type' => $request->get('ut'),
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['advert_data']);

        $this->view->render("admin/adverts/create", $view);
    }

    public function create(Request $request)
    {
        $adverts = new Advertisements();

        $uploadType = $request->get("ut");

        if ($request->isPost()) {
            $adverts->fillable([
                'advert_id',
                'name',
                'link',
                'advert_img',
                'priority',
                'status'
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['advert_id'] = generateUuidV4();
            $adverts->setIsInsertionScenario('create'); // Set insertion scenario flag
            $uploader = new Upload("uploads/advertisements");
            $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            if ($adverts->validate($data)) {
                if ($uploadType === "file") {
                    $advert_img = $uploader->uploadFile('advert_img');

                    if (isset($advert_img['error']) || !empty($advert_img['advert_img'])) {
                        FlashMessage::setMessage($advert_img['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                    }

                    if ($advert_img['success']) {
                        $data['advert_img'] = $advert_img['path'];

                        $image = new Image();
                        $image->resize($data['advert_img']);
                        // $image->watermark($data['advert_img'], "assets/img/natti.png");
                    }
                }

                if ($adverts->insert($data)) {
                    toast("success", "Advertisement Created Successfully");
                    redirect(URL_ROOT . "admin/manage-advertisements");
                }
            } else {
                storeSessionData('advert_data', $data);
            }
        }
        toast("error", "Advertisement Creation Failed!");
        Bolt::$bolt->session->setFormMessage($adverts->getErrors());
        redirect(URL_ROOT . "admin/advertisements/create?ut={$uploadType}");
    }

    public function edit_advert(Request $request)
    {
        $id = $request->getParameter("id");

        $adverts = new Advertisements();

        $advert = $adverts->findOne([
            'advert_id' => $id,
        ]);

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'advert' => $advert ?? retrieveSessionData('advert_data'),
            'title' => 'Edit Advertisement',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Advertisements', 'url' => 'admin/manage-advertisements'],
                ['label' => 'Edit Advertisement', 'url' => ''],
            ],
            'priorityOpts' => [
                'none' => 'None',
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
                'banner' => 'Banner*',
            ],
            'statusOpts' => [
                'pending' => 'Pending',
                'open' => 'Open',
                'closed' => 'Closed',
                'expired' => 'Expired',
            ],
            'upload_type' => $request->get('ut'),
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['advert_data']);

        $this->view->render("admin/adverts/edit", $view);
    }

    public function edit(Request $request)
    {
        $id = $request->getParameter("id");

        $uploadType = $request->get("ut");

        $adverts = new Advertisements();

        $advert = $adverts->findOne([
            'advert_id' => $id,
        ]);

        if (!$advert) {
            toast("info", "Advert Not Found!");
            redirect(URL_ROOT . "admin/manage-advertisements");
        }

        if ($request->isPost()) {
            $adverts->updatable([
                'name',
                'link',
                'advert_img',
                'priority',
                'status'
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['advert_img'] = $advert->advert_img;
            $adverts->setIsInsertionScenario('edit'); // Set insertion scenario flag
            $uploader = new Upload("uploads/advertisements");
            $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            if ($adverts->validate($data)) {
                if ($uploadType === "file") {
                    if (!empty($_FILES['advert_img']['name'])) {
                        $advert_img = $uploader->uploadFile('advert_img');

                        if (isset($advert_img['error']) || !empty($advert_img['advert_img'])) {
                            FlashMessage::setMessage($advert_img['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                        }

                        if ($advert_img['success']) {
                            if ($advert->advert_img !== null) {
                                $uploader->deleteFile($advert->advert_img);
                            }
                            $data['advert_img'] = $advert_img['path'];

                            $image = new Image();
                            $image->resize($data['advert_img']);
                            // $image->watermark($data['advert_img'], "assets/img/natti.png");
                        }
                    }
                }

                if ($adverts->updateBy($data, ['advert_id' => $id])) {
                    toast("success", "Advertisement Updated Successfully");
                    redirect(URL_ROOT . "admin/manage-advertisements");
                }
            } else {
                storeSessionData('advert_data', $data);
            }
        }
        toast("info", "Nothing to Update - No changes made!");
        Bolt::$bolt->session->setFormMessage($adverts->getErrors());
        redirect(URL_ROOT . "admin/manage-advertisements");
    }

    public function delete_advert(Request $request)
    {
        $id = $request->getParameter("id");

        $adverts = new Advertisements();

        $advert = $adverts->findOne([
            'advert_id' => $id,
        ]);

        if (!$advert) {
            toast("info", "Advertisement Not Found!");
            redirect(URL_ROOT . "admin/manage-advertisements");
        }

        $view = [
            'advert' => $advert,
            'title' => 'Delete Advertisement',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Advertisements', 'url' => 'admin/manage-advertisements'],
                ['label' => 'Delete Advertisement', 'url' => ''],
            ],
        ];

        $this->view->render("admin/adverts/delete", $view);
    }

    public function delete(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);

            $id = $request->getParameter("id");

            $adverts = new Advertisements();

            $advert = $adverts->findOne([
                'advert_id' => $id,
            ]);

            if (!$advert) {
                toast("info", "Advertisement Not Found!");
                redirect(URL_ROOT . "admin/manage-advertisements");
            }

            if ($advert) {
                unlink($advert->advert_img);

                if ($adverts->deleteBy(['advert_id' => $id])) {
                    toast("success", "Advertisement Deleted Successfully!");
                    redirect(URL_ROOT . "admin/manage-advertisements");
                }
            }
            toast("error", "Failure on Deleting process!");
            redirect(URL_ROOT . "admin/manage-advertisements");
        }
    }

    private function access(array $data)
    {
        if (!hasAccess($data, 'all', [])) {
            toast("info", "PERMISSION NOT GRANTED!");
            redirect(URL_ROOT . "admin", 401);
        }
    }
}
