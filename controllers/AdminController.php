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

use DateTime;
use DateInterval;
use celionatti\Bolt\Bolt;
use PhpStrike\models\Users;
use PhpStrike\models\Articles;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\Image;
use celionatti\Bolt\Helpers\Upload;
use celionatti\Bolt\Authentication\BoltAuthentication;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;

class AdminController extends Controller
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
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'title' => 'Profile',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Profile', 'url' => ''],
            ],
            'user' => $this->currentUser ?? retrieveSessionData('user_data'),
            'genderOpts' => [
                'male' => 'Male',
                'female' => 'Female',
                'others' => 'Others',
            ],
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/profile/profile", $view);
    }

    public function update_profile(Request $request)
    {
        if ($request->isPost()) {
            if (!$this->currentUser) {
                toast("info", "Access Authorized!");
                redirect(URL_ROOT);
            }
            $users = new Users();

            $user = $this->currentUser;

            $u = $users->findOne(['user_id' => $user->user_id]);

            $users->updatable([
                'surname',
                'name',
                'email',
                'phone',
                'gender',
                'bio',
                'birth_date',
                'facebook',
                'twitter',
                'instagram',
                'avatar',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);

            $data['avatar'] = $u->avatar;
            $users->setIsInsertionScenario('edit'); // Set insertion scenario flag
            $uploader = new Upload("uploads/users");
            $uploader->setAllowedFileTypes(ALLOWED_IMAGE_FILE_UPLOAD);
            $uploader->setOverwriteExisting(true);

            if ($users->validate($data)) {
                if (!empty($_FILES['avatar']['name'])) {
                    $avatar = $uploader->uploadFile('avatar');

                    if (isset($avatar['error']) || !empty($avatar['avatar'])) {
                        FlashMessage::setMessage($avatar['error'], FlashMessage::WARNING, ['role' => 'alert', 'style' => 'z-index: 9999;']);
                    }

                    if ($avatar['success']) {
                        if ($u->avatar !== null) {
                            $uploader->deleteFile($u->avatar);
                        }
                        $data['avatar'] = $avatar['path'];

                        $image = new Image();
                        $image->resize($data['avatar']);
                        $image->watermark($data['avatar'], "assets/img/natti.png");
                    }
                }

                if ($users->updateBy($data, ['user_id' => $user->user_id])) {
                    toast("success", "Profile Updated Successfully");
                    redirect(URL_ROOT . "admin/profile");
                }
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("info", "Nothing to Update - No changes made!");
        Bolt::$bolt->session->setFormMessage($users->getErrors());
        redirect(URL_ROOT . "admin/profile");
    }

    public function password()
    {
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'title' => 'Change Password',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Profile', 'url' => 'admin/profile'],
                ['label' => 'Change Password', 'url' => ''],
            ],
            'user' => retrieveSessionData('user_data'),
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/profile/change-password", $view);
    }

    public function change_password(Request $request)
    {
        if ($request->isPost()) {
            if (!$this->currentUser) {
                toast("info", "Access Authorized!");
                redirect(URL_ROOT);
            }
            $users = new Users();

            $user = $this->currentUser;

            $u = $users->findOne(['user_id' => $user->user_id]);

            $users->updatable([
                'password',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);

            $users->setIsInsertionScenario('change-password'); // Set insertion scenario flag
            $users->passwordsMatchValidation($data['password'], $data['confirm_password']);

            if (!password_verify($data['old_password'], $u->password)) {
                toast("error", "Check the Old Password!");
                Bolt::$bolt->session->setFormMessage($users->getErrors());
                redirect(URL_ROOT . "admin/change-password");
            }

            if ($users->validate($data)) {
                // other method before saving.
                $options = ['cost' => 12];
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, $options);
                if ($users->updateBy($data, ['user_id' => $u->user_id])) {
                    toast("success", "Password Changed Successfully!");
                    redirect(URL_ROOT . "admin/profile");
                }
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("error", "Change of Password Falied!");
        Bolt::$bolt->session->setFormMessage($users->getErrors());
        redirect(URL_ROOT . "admin/change-password");
    }

    public function delete_profile(Request $request)
    {
        $currentDate = new DateTime();
        $updatedDate = new DateTime($this->currentUser->updated_at);
        $targetDate = $updatedDate->add(new DateInterval('P30D'));

        $view = [
            'errors' => [],
            'title' => 'Delete Profile',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Profile', 'url' => 'admin/profile'],
                ['label' => 'Delete Profile', 'url' => ''],
            ],
            'user' => $this->currentUser,
            'intDays' => $currentDate->diff($targetDate)->format('%a'),
            'intHrs' => $currentDate->diff($targetDate)->h,
            'intMins' => $currentDate->diff($targetDate)->i,
            'intSecs' => $currentDate->diff($targetDate)->s,
            'targetDate' => $targetDate,
        ];

        $this->view->render("admin/profile/delete-profile", $view);
    }

    public function delete(Request $request)
    {
        // Check if the request is a POST request
        if (!$request->isPost()) {
            return; // Exit early if the request is not POST
        }

        // If there is no current user, redirect with a message and exit early
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
            return;
        }

        // Initialize the Users model
        $users = new Users();
        $user = $this->currentUser;

        // Find the current user's record in the database
        $u = $users->findOne(['user_id' => $user->user_id]);
        if (!$u) {
            toast("error", "User not found!");
            redirect(URL_ROOT . "admin/delete-profile");
            return;
        }

        // Specify which fields can be updated
        $users->updatable(['is_deleted']);

        // Get the request data and validate CSRF token
        $data = $request->getBody();
        validate_csrf_token($data);

        // Set insertion scenario flag
        $users->setIsInsertionScenario('delete-profile');

        // Verify the provided password
        if (!password_verify($data['password'], $u->password)) {
            toast("error", "Check the Password - Not Valid!");
            Bolt::$bolt->session->setFormMessage($users->getErrors());
            redirect(URL_ROOT . "admin/delete-profile");
            return;
        }

        // Validate the data
        if ($users->validate($data)) {
            $data['is_deleted'] = 1;

            // Update the user's record in the database
            if ($users->updateBy($data, ['user_id' => $u->user_id])) {
                // Successfully updated, redirect to a success page or home page
                toast("success", "Profile successfully deleted!");
                redirect(URL_ROOT . "admin/profile"); // Change to the desired URL
                return; // Ensure the function exits after redirect
            } else {
                toast("error", "Failed to update user profile!");
                redirect(URL_ROOT . "admin/admin/profile");
                return;
            }
        } else {
            Bolt::$bolt->session->setFormMessage($users->getErrors());
            redirect(URL_ROOT . "admin/delete-profile");
        }
    }

    public function cancel(Request $request)
    {
        // Check if the request is a GET request
        if (!$request->isGet()) {
            return; // Exit early if the request is not GET
        }

        // If there is no current user, redirect with a message and exit early
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
            return;
        }

        // Initialize the Users model
        $users = new Users();
        $user = $this->currentUser;

        // Find the current user's record in the database
        $u = $users->findOne(['user_id' => $user->user_id]);
        if (!$u) {
            toast("error", "User not found!");
            redirect(URL_ROOT . "admin/delete-profile");
            return;
        }

        // Specify which fields can be updated
        $users->updatable(['is_deleted']);

        // Get the request data and validate CSRF token
        $data = [];

        // Validate the data
        $data['is_deleted'] = 0;

        // Update the user's record in the database
        if ($users->updateBy($data, ['user_id' => $u->user_id])) {
            // Successfully updated, redirect to a success page or home page
            toast("success", "Profile Delete Process Cancel successfully!");
            redirect(URL_ROOT . "admin/profile"); // Change to the desired URL
            return; // Ensure the function exits after redirect
        } else {
            toast("error", "Failed to update user profile!");
            redirect(URL_ROOT . "admin/delete-profile");
            return;
        }
    }

    public function profile_articles(Request $request)
    {
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
        }

        $view = [
            'title' => 'My Articles',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Profile', 'url' => 'admin/profile'],
                ['label' => 'My Articles', 'url' => ''],
            ],
            'user' => $this->currentUser,
        ];

        $this->view->render("admin/profile/articles", $view);
    }

    public function view_profile_articles(Request $request)
    {
        if (!$this->currentUser) {
            toast("info", "Access Authorized!");
            redirect(URL_ROOT);
        }
        
        if ($request->isPost() && $request->post('action') === "view-articles") {
            $articles = new Articles();
            $data = $articles->findAllBy(['user_id' => $this->currentUser->user_id]);

            if (empty($data)) {
                return '<h3 class="text-center text-secondary mt-5">:( No article present in the database!</h3>';
            }

            $output = $this->generateArticlesTable($data);
            $this->json_response($output);
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
        $deleteUrl = URL_ROOT . "admin/articles/delete/{$row->article_id}";

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
                <a href='{$deleteUrl}' title='Delete Article' class='btn btn-sm btn-outline-danger px-3 py-1 my-1'><i class='bi bi-trash'></i></a>
            </td>
        </tr>";
    }
}
