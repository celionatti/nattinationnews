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
use PhpStrike\models\Articles;
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

        // if (!hasAccess([], 'all', ['user', 'guest'])) {
        //     redirect("/", 401);
        // }
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($key + 1) . '</td>
                    <td><img src="' . get_image($row->avatar) . '" class="d-block" style="height:50px;width:50px;object-fit:cover;border-radius: 10px;cursor: pointer;"></td>
                    <td class="text-capitalize">' . $row->surname . ' ' . $row->name . '</td>
                    <td class="text-capitalize">' . $row->email .'</td>
                    <td class="text-capitalize">' . $row->gender .'</td>
                    <td class="text-capitalize">' . $row->role .'</td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/users/edit/{$row->user_id}?ut=file" . '" title="Edit User" class="btn btn-sm btn-outline-primary px-3 py-1 my-1"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

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
            'upload_type' => $request->get('ut'),
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/users/create", $view);
    }
}
