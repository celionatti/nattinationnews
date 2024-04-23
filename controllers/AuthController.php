<?php

declare(strict_types=1);

/**
 * ===================================================
 * =================            ======================
 * AuthController
 * =================            ======================
 * ===================================================
 */

namespace PhpStrike\controllers;

use celionatti\Bolt\Bolt;
use PhpStrike\models\Users;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Authentication\BoltAuthentication;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;

class AuthController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout("auth");
    }

    public function signup_view(Request $request)
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect("/");
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => retrieveSessionData('user_data'),
            'genderOpts' => [
                'male' => 'Male',
                'female' => 'Female',
                'others' => 'Others'
            ]
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("auth/signup", $view);
    }

    public function signup(Request $request)
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect("/");
        }

        $user = new Users();

        if ($request->isPost()) {
            $user->fillable([
                'user_id',
                'surname',
                'othername',
                'phone',
                'email',
                'gender',
                'role',
                'password'
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['user_id'] = generateUuidV4();
            $user->setIsInsertionScenario('signup'); // Set insertion scenario flag
            $user->passwordsMatchValidation($data['password'], $data['confirm_password']);
            if ($user->validate($data)) {
                // other method before saving.
                $options = ['cost' => 12];
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, $options);
                if ($user->insert($data)) {
                    toast("success", "User Created Successfully");
                    redirect("/");
                }
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("error", "Registration Falied!");
        Bolt::$bolt->session->setFormMessage($user->getErrors());
        redirect("/signup");
    }

    public function login_view()
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect("/");
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => retrieveSessionData('user_data'),
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("auth/login", $view);
    }

    public function login(Request $request)
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect("/");
        }

        $user = new Users();

        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);
            $user->setIsInsertionScenario("login"); // Set insertion scenario flag
            if ($user->validate($data)) {
                $auth = new BoltAuthentication();
                $auth->login($data['email'], $data['password'], $data['remember'] ?? false);
            } else {
                storeSessionData('user_data', $data);
            }
        }
        toast("error", "Authentication Failure!");
        Bolt::$bolt->session->setFormMessage($user->getErrors());
        redirect("/login");
    }

    public function forgot_view()
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect("/");
        }
        
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => retrieveSessionData('user_data'),
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("auth/forgot-password", $view);
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
