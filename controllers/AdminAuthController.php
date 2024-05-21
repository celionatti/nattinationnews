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

class AdminAuthController extends Controller
{
    public function onConstruct(): void
    {
        $this->view->setLayout("auth");

        if (hasAccess(['admin', 'manager', 'editor', 'journalist'], 'all', [])) {
            redirect(URL_ROOT . "admin", 401);
        }
    }

    public function login_view()
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect(URL_ROOT . "admin");
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'user' => retrieveSessionData('user_data'),
        ];

        // Remove the user data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['user_data']);

        $this->view->render("admin/auth/login", $view);
    }

    public function login(Request $request)
    {
        if ($this->currentUser = BoltAuthentication::currentUser()) {
            redirect(URL_ROOT . "admin");
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
        redirect(URL_ROOT . "dashboard/login");
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
