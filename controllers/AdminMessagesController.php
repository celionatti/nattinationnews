<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminMessagesController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;


use celionatti\Bolt\Bolt;
use celionatti\Bolt\Controller;
use PhpStrike\models\Categories;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\FlashMessages\FlashMessage;
use celionatti\Bolt\Helpers\Utils\StringUtils;
use PhpStrike\models\Contacts;

class AdminMessagesController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        $this->currentUser = user();

        if (is_null($this->currentUser)) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
        $this->auto_delete_messages();
    }

    public function manage()
    {
        $view = [
            'title' => 'Manage Messages',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Messages', 'url' => ''],
            ],
        ];

        $this->view->render("admin/messages/manage", $view);
    }

    public function view_messages(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-messages") {
                $output = '';
                $contacts = new Contacts();

                $data = $contacts->findAll();

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Label</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-center text-scondary">
                    <td>' . ($row->status === "unread" ? '<i class="fa-regular fa-envelope"></i>' : '<i class="fa-regular fa-envelope-open"></i>') . '</td>
                    <td class="text-capitalize">' . $row->name . '</td>
                    <td class="">' . $row->email . '</td>
                    <td class=""><p>' . StringUtils::excerpt($row->message, 50) . '</p></td>
                    <td class="text-capitalize">' . statusVerification($row->label) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/messages/open/{$row->contact_id}" . '" title="Open Message" class="btn btn-sm btn-outline-primary px-3 py-1 my-1">Open</a>

                    <a href="' . URL_ROOT . "admin/messages/delete/{$row->contact_id}" . '" title="Delete Message" class="btn btn-sm btn-outline-danger px-3 py-1 my-1"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No message present in the database!</h3>';
            }
        }
    }

    public function open_message(Request $request)
    {
        if ($request->isGet()) {
            $view = [
                'title' => 'Message Details',
                'navigations' => [
                    ['label' => 'Dashboard', 'url' => 'admin'],
                    ['label' => 'Manage Messages', 'url' => 'admin/manage-messages'],
                    ['label' => 'Message Details', 'url' => ''],
                ],
                'message_id' => $request->getParameter("id"),
            ];

            $this->view->render("admin/messages/open", $view);
        }

        if ($request->isPost()) {
            if ($request->post("open") && $request->post("open") === "true") {
                $id = $request->post("message_id");
                $contacts = new Contacts();

                $contact = $contacts->findOne(['contact_id' => $id]);

                $contacts->updatable([
                    'status'
                ]);

                $data = [
                    'status' => 'read'
                ];

                if ($contact) {
                    $contacts->updateBy($data, ['contact_id' => $id]);
                }
            }

            if ($request->post("action") && $request->post("action") === "open-message") {
                $id = $request->post("message_id");
                $output = '';
                $contacts = new Contacts();

                $data = $contacts->findOne(['contact_id' => $id]);

                $output .= '<div class="card text-center">';

                $output .= '<div class="card-header">';
                $output .= '<h4>Message Details</h4>';
                $output .= '</div>';

                $output .= '<div class="card-body">';
                $output .= '<p class="card-text text-start text-bg-dark p-1 text-capitalize"><span>Author: </span>' . $data->name . '</p>';
                $output .= '<p class="card-text text-start text-bg-dark p-1"><span>Email: </span>' . $data->email . '</p>';
                $output .= '<p class="bg-dark text-white px-3 py-4 text-start">' . $data->message . '</p>';
                $output .= '</div>';

                $output .= '<div class="card-footer text-body-secondary d-flex justify-content-between align-items-center">';
                $output .= '<small>' . date("d M, Y", strtotime($data->created_at)) . '</small>';
                $output .= '<div>';
                $output .= '<a href="' . URL_ROOT . "admin/messages/delete/{$data->contact_id}" . '" class="btn btn-sm"><i class="fa-solid fa-trash-alt text-danger mx-1"></i></a>';
                $output .= '<a href="' . URL_ROOT . "admin/messages/open/important/{$data->contact_id}" . '" class="btn btn-sm">'.($data->label === "important" ? '<i class="fa-solid fa-star text-warning mx-1"></i>' : '<i class="fa-regular fa-star text-warning mx-1"></i>').'</a>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '</div>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No message present in the database!</h3>';
            }
        }
    }

    public function important_message(Request $request)
    {
        $id = $request->getParameter("id");

        $contacts = new Contacts();

        $contacts->updatable([
            'label'
        ]);

        $contact = $contacts->findOne(['contact_id' => $id]);

        if ($contact) {
            if ($contacts->updateBy(['label' => 'important'], ['contact_id' => $id])) {
                toast('success', "Message Label Important!");
                redirect(URL_ROOT . "admin/messages/open/{$id}");
            }
        }
        toast('info', "Something went Wrong!");
        redirect(URL_ROOT . "admin/messages/open/{$id}");
    }

    public function delete_message(Request $request)
    {
        $id = $request->getParameter("id");

        $contacts = new Contacts();

        $contact = $contacts->findOne(['contact_id' => $id]);

        $roles = ["admin", "manager", "community_manager"];

        if (hasRole($this->currentUser, $roles)) {
            if (!$contact) {
                toast('info', "Message Not Found!");
                redirect('/admin/manage-messages');
            }

            if ($contact) {
                if ($contacts->deleteBy(['contact_id' => $id])) {
                    toast("success", "Message Deleted Successfully!");
                    redirect(URL_ROOT . "admin/manage-messages");
                }
                toast("error", "Failed in Deleting Process!");
                redirect(URL_ROOT . "admin/manage-messages");
            }
        }
        toast("info", "You dont have access to Update!");
        redirect(URL_ROOT . "admin/manage-messages");
    }

    private function auto_delete_messages()
    {
        $contacts = new Contacts();

        $contact = $contacts->autoDelete();

        if ($contact) {
            toast("success", "Messages Auto Deleted!");
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
