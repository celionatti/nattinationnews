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

use celionatti\Bolt\Bolt;
use PhpStrike\models\Users;
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

        $this->view->render("admin/profile", $view);
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

        $this->view->render("admin/change-password", $view);
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

    public function logout(Request $request)
    {
        if ($request->isGet()) {
            $auth = new BoltAuthentication();

            if ($auth->logout()) {
                // Display a message indicating that the account is blocked.
                FlashMessage::setMessage("Logout Successfully.!", FlashMessage::SUCCESS, ['role' => 'alert', 'style' => 'z-index: 9999;']);

                redirect("/");
            }
            redirect("/");
        }
    }
}
