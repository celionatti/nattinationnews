<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminSettingsController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;


use celionatti\Bolt\Bolt;
use PhpStrike\models\Settings;
use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use celionatti\Bolt\Helpers\Utils\StringUtils;

class AdminSettingsController extends Controller
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
        $this->access(['admin', 'manager']);
        $view = [
            'title' => 'Manage Settings',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Settings', 'url' => ''],
            ],
        ];

        $this->view->render("admin/settings/manage", $view);
    }

    public function view_settings(Request $request)
    {
        $this->access(['admin', 'manager']);
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-settings") {
                $output = '';
                $settings = new Settings();

                $data = $settings->findAll();

                if (empty($data)) {
                    return '<h3 class="text-center text-secondary mt-5">:( No setting present in the database!</h3>';
                }

                $output = $this->generateSettingsTable($data);
                $this->json_response($output);
            }
        }
    }

    public function create_setting(Request $request)
    {
        $this->access(['admin', 'manager']);
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'setting' => retrieveSessionData('setting_data'),
            'title' => 'Create Setting',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Settings', 'url' => 'admin/manage-settings'],
                ['label' => 'Create Setting', 'url' => ''],
            ],
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['setting_data']);

        $this->view->render("admin/settings/create", $view);
    }

    public function create(Request $request)
    {
        $this->access(['admin', 'manager']);
        $settings = new Settings();

        if ($request->isPost()) {
            $settings->fillable([
                'setting_id',
                'name',
                'value',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['setting_id'] = generateUuidV4();
            $settings->setIsInsertionScenario('create'); // Set insertion scenario flag

            if ($settings->validate($data)) {
                if ($settings->insert($data)) {
                    toast("success", "Settings Created Successfully");
                    redirect(URL_ROOT . "admin/manage-settings");
                }
            } else {
                storeSessionData('setting_data', $data);
            }
        }
        toast("error", "Setting Creation Failed!");
        Bolt::$bolt->session->setFormMessage($settings->getErrors());
        redirect(URL_ROOT . "admin/settings/create");
    }

    public function edit_setting(Request $request)
    {
        $this->access(['admin', 'manager']);
        $id = $request->getParameter("id");

        $settings = new Settings();

        $setting = $settings->findOne([
            'setting_id' => $id,
        ]);

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'setting' => $setting ?? retrieveSessionData('setting_data'),
            'title' => 'Edit Setting',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Settings', 'url' => 'admin/manage-settings'],
                ['label' => 'Edit Setting', 'url' => ''],
            ],
            'statusOpts' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['setting_data']);

        $this->view->render("admin/settings/edit", $view);
    }

    public function edit(Request $request)
    {
        $this->access(['admin', 'manager']);
        $id = $request->getParameter("id");

        $settings = new Settings();

        $s = $settings->findOne([
            'setting_id' => $id,
        ]);

        if (!$s) {
            toast("info", "Setting Not Found!");
            redirect("/admin/manage-settings");
        }

        if ($request->isPost()) {
            $settings->updatable([
                'name',
                'value',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $settings->setIsInsertionScenario('edit'); // Set insertion scenario flag

            if ($settings->validate($data)) {
                if ($settings->updateBy($data, ['setting_id' => $id])) {
                    toast("success", "Settings Updated Successfully");
                    redirect(URL_ROOT . "admin/manage-settings");
                }
            } else {
                storeSessionData('setting_data', $data);
            }
        }
        toast("info", "Setting Creation Failed!");
        Bolt::$bolt->session->setFormMessage($settings->getErrors());
        redirect("/admin/settings/edit/{$id}");
    }

    public function delete_setting(Request $request)
    {
        $this->access(['admin', 'manager']);
        $id = $request->getParameter("id");

        $settings = new Settings();

        $data = $settings->findOne([
            'setting_id' => $id,
        ]);

        $view = [
            'setting' => $data,
            'title' => 'Delete Setting',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Settings', 'url' => 'admin/manage-settings'],
                ['label' => 'Delete Setting', 'url' => ''],
            ],
        ];

        $this->view->render("admin/settings/delete", $view);
    }

    public function delete(Request $request)
    {
        $this->access(['admin', 'manager']);
        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);

            $id = $request->getParameter("id");
            $settings = new Settings();

            $s = $settings->findOne(['setting_id' => $id]);

            if (!$s) {
                toast('info', "Setting Not Found!");
                redirect(URL_ROOT . 'admin/manage-settings');
            }

            if ($s) {
                if ($settings->deleteBy(['setting_id' => $id])) {
                    toast("success", "Setting Deleted Successfully!");
                    redirect(URL_ROOT . "admin/manage-settings");
                }
            }
            toast("error", "Failure on Deleting process!");
            redirect(URL_ROOT . "admin/manage-settings");
        }
    }

    private function generateSettingsTable($data)
    {
        $output = '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($data as $key => $row) {
            $output .= $this->generateSettingRow($key, $row);
        }

        $output .= '</tbody></table>';
        return $output;
    }

    private function generateSettingRow($key, $row)
    {
        $status = statusVerification($row->status);
        $editUrl = URL_ROOT . "admin/settings/edit/{$row->setting_id}";
        $deleteUrl = URL_ROOT . "admin/settings/delete/{$row->setting_id}";
        $value = StringUtils::excerpt(htmlspecialchars_decode(nl2br($row->value)), 250);

        return "
        <tr class='text-center text-secondary'>
            <td>" . ($key + 1) . "</td>
            <td class='text-dark'>{$row->name}</td>
            <td class='text-dark'>{$value}</td>
            <td class='text-capitalize'>{$status}</td>
            <td>
                <a href='{$editUrl}' title='Edit Setting' class='btn btn-sm btn-outline-warning px-2 py-1 my-1'><i class='bi bi-pencil-square'></i></a>
                <a href='{$deleteUrl}' title='Delete Setting' class='btn btn-sm btn-outline-danger px-2 py-1 my-1'><i class='bi bi-trash'></i></a>
            </td>
        </tr>";
    }

    private function access(array $data)
    {
        if (!hasAccess($data)) {
            toast("info", "PERMISSION NOT GRANTED!");
            redirect(URL_ROOT . "admin", 401);
        }
    }
}
