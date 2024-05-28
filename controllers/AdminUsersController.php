<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminUsersController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;

use OpenAI;

use celionatti\Bolt\Bolt;
use PhpStrike\models\Users;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\Image;
use celionatti\Bolt\Helpers\Upload;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;

class AdminUsersController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        $this->currentUser = user();

        if (!hasAccess(['admin', 'manager', 'editor', 'journalist'], 'all', [])) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
    }

    public function manage()
    {
        $view = [
            'title' => 'Manage Users',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Users', 'url' => ''],
            ],
        ];

        $this->view->render("admin/users/manage", $view);
    }

    public function view(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-users") {
                $output = '';
                $users = new Users();

                $data = $users->findAll();

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <th>Verified</th>
                        <th>Blocked</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td><img src="' . get_image($row->avatar) . '" class="d-block" style="height:50px;width:50px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . $row->surname . ' ' . $row->name . '</td>
                    <td class="text-dark">' . $row->email . '</td>
                    <td class="text-capitalize">' . $row->gender . '</td>
                    <td class="text-capitalize">' . userRoleType($row->role) . '</td>
                    <td class="text-capitalize">' . userVerification($row->is_verified) . '</td>
                    <td class="text-capitalize">' . userBlocked($row->is_blocked) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/users/edit/{$row->user_id}" . '" title="Edit User" class="btn btn-sm btn-outline-primary px-3 py-1 my-1"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/users/delete/{$row->user_id}" . '" title="Delete User" class="btn btn-sm btn-outline-danger px-3 py-1 my-1"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No user present in the database!</h3>';
            }
        }
    }

    public function create_user(Request $request)
    {
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => retrieveSessionData('user_data'),
            'title' => 'Create User',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Users', 'url' => 'admin/manage-users'],
                ['label' => 'Create User', 'url' => ''],
            ],
            'genderOpts' => [
                'male' => 'Male',
                'female' => 'Female',
                'others' => 'Others',
            ],
            'roleOpts' => [
                'editor' => 'Editor',
                'manager' => 'Manager',
                'journalist' => 'Journalist',
                'admin' => 'Admin',
            ],
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/users/create", $view);
    }

    public function create(Request $request)
    {
        $users = new Users();

        if ($request->isPost()) {
            $users->fillable([
                'user_id',
                'id_number',
                'surname',
                'name',
                'email',
                'phone',
                'password',
                'gender',
                'role',
                'token',
                'is_verified',
                'is_blocked',
                'file',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['user_id'] = generateUuidV4();
            $data['id_number'] = generateRandomID(['123456', '999999', '000000']);
            $data['password'] = '@' . strtolower($data['surname']) . 'Password1';
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $hashedPassword;
            $data['token'] = generateToken();

            $users->setIsInsertionScenario('create'); // Set insertion scenario flag

            $uploader = new Upload("uploads/files");
            $uploader->setAllowedFileTypes(ALLOWED_DOC_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            if ($users->validate($data)) {
                $file = $uploader->uploadFile('file');

                if (isset($file['error']) || !empty($file['file'])) {
                    FlashMessage::setMessage($file['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                }

                if ($file['success']) {
                    $data['file'] = $file['path'];
                }

                if ($users->insert($data)) {
                    toast("success", "User Created Successfully");
                    redirect(URL_ROOT . "admin/manage-users");
                }
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("error", "User Creation Failed!");
        Bolt::$bolt->session->setFormMessage($users->getErrors());
        redirect(URL_ROOT . "admin/users/create");
    }

    public function edit_user(Request $request)
    {
        $id = $request->getParameter("id");

        $users = new Users();

        $user = $users->findOne(['user_id' => $id]);

        if (!$user) {
            toast("info", "User Not Found!");
            redirect(URL_ROOT . "admin/manage-users");
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => $user,
            'title' => 'Edit User',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Users', 'url' => 'admin/manage-users'],
                ['label' => 'Edit User', 'url' => ''],
            ],
            'genderOpts' => [
                'male' => 'Male',
                'female' => 'Female',
                'others' => 'Others',
            ],
            'roleOpts' => [
                'editor' => 'Editor',
                'manager' => 'Manager',
                'journalist' => 'Journalist',
                'admin' => 'Admin',
            ],
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/users/edit", $view);
    }

    public function edit(Request $request)
    {
        if ($request->isPost()) {
            $id = $request->getParameter("id");

            $users = new Users();

            $user = $users->findOne(['user_id' => $id]);

            if (!$user) {
                toast("info", "User Not Found!");
                redirect(URL_ROOT . "admin/manage-users");
            }

            $users->updatable([
                'surname',
                'name',
                'email',
                'phone',
                'gender',
                'role',
                'file',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);

            $data['file'] = $user->file;
            $users->setIsInsertionScenario('user-edit'); // Set insertion scenario flag
            $uploader = new Upload("uploads/files");
            $uploader->setAllowedFileTypes(ALLOWED_DOC_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            if ($users->validate($data)) {
                if (!empty($_FILES['file']['name'])) {
                    $file = $uploader->uploadFile('file');

                    if (isset($avatar['error']) || !empty($file['file'])) {
                        FlashMessage::setMessage($file['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                    }

                    if ($file['success']) {
                        if ($user->file !== null) {
                            $uploader->deleteFile($user->file);
                        }
                        $data['file'] = $file['path'];
                    }
                }

                if ($users->updateBy($data, ['user_id' => $id])) {
                    toast("success", "User Updated Successfully");
                    redirect(URL_ROOT . "admin/manage-users");
                }
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("info", "Nothing to Update - No changes made!");
        Bolt::$bolt->session->setFormMessage($users->getErrors());
        redirect(URL_ROOT . "admin/manage-users");
    }
}
