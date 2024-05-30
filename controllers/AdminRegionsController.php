<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminRegionsController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;

use celionatti\Bolt\Bolt;

use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use PhpStrike\models\Categories;
use PhpStrike\models\Regions;

class AdminRegionsController extends Controller
{
    public $currentUser = null;

    public function onConstruct(): void
    {
        $this->view->setLayout("admin");

        if (is_null($this->currentUser)) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
    }

    public function manage()
    {
        $view = [
            'title' => 'Manage Regions',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Regions', 'url' => ''],
            ],
        ];

        $this->view->render("admin/regions/manage", $view);
    }

    public function create_region(Request $request)
    {
        $this->access();
        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'region' => retrieveSessionData('region_data'),
            'title' => 'Create Region',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Create Region', 'url' => ''],
            ],
            'statusOpts' => [
                'disable' => 'Disable',
                'active' => 'Active',
            ],
        ];

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['region_data']);

        $this->view->render("admin/regions/create", $view);
    }

    public function create(Request $request)
    {
        $this->access();
        if ($request->isPost()) {
            $regions = new Regions();

            $regions->fillable([
                'region_id',
                'region',
                'region_info',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['region_id'] = generateUuidV4();

            $regions->setIsInsertionScenario('create'); // Set insertion scenario flag

            if ($regions->validate($data)) {
                if ($regions->insert($data)) {
                    toast("success", "Region Created Successfully");
                    redirect(URL_ROOT . "admin/manage-regions");
                }
            } else {
                storeSessionData('region_data', $data);
            }
        }
        toast("error", "Region Creation Failed!");
        Bolt::$bolt->session->setFormMessage($regions->getErrors());
        redirect(URL_ROOT . "admin/regions/create");
    }

    public function edit_region(Request $request)
    {
        $this->access();
        $id = $request->getParameter("id");

        $regions = new Regions();

        $region = $regions->findOne([
            'region_id' => $id,
        ]);

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'region' => $region ?? retrieveSessionData('region_data'),
            'title' => 'Edit Region',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Regions', 'url' => 'admin/manage-regions'],
                ['label' => 'Edit Region', 'url' => ''],
            ],
            'statusOpts' => [
                'disable' => 'Disable',
                'active' => 'Active',
            ],
        ];

        // Remove the region data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['region_data']);

        $this->view->render("admin/regions/edit", $view);
    }

    public function edit(Request $request)
    {
        $this->access();
        if ($request->isPost()) {
            $id = $request->getParameter("id");

            $regions = new Regions();

            $region = $regions->findOne([
                'region_id' => $id,
            ]);

            if (!$region) {
                toast("info", "Region Not Found!");
                redirect(URL_ROOT . "admin/manage-regions");
            }

            $regions->updatable([
                'region',
                'region_info',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);

            $regions->setIsInsertionScenario('edit'); // Set insertion scenario flag

            if ($regions->validate($data)) {
                if ($regions->updateBy($data, ['region_id' => $id])) {
                    toast("success", "Region Updated Successfully");
                    redirect(URL_ROOT . "admin/manage-regions");
                }
            } else {
                storeSessionData('region_data', $data);
            }
        }
        toast("info", "No Changes Made - Nothing Was Updated!");
        Bolt::$bolt->session->setFormMessage($regions->getErrors());
        redirect(URL_ROOT . "admin/manage-regions");
    }

    public function delete_region(Request $request)
    {
        $this->access();
        $id = $request->getParameter("id");

        $regions = new Regions();

        $region = $regions->findOne([
            'region_id' => $id,
        ]);

        $view = [
            'title' => 'Delete Region',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Regions', 'url' => 'admin/manage-regions'],
                ['label' => 'Delete Region', 'url' => ''],
            ],
            'region' => $region,
        ];

        $this->view->render("admin/regions/delete", $view);
    }

    public function delete(Request $request)
    {
        $this->access();
        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);

            $id = $request->getParameter("id");

            $regions = new Regions();

            $region = $regions->findOne([
                'region_id' => $id,
            ]);

            if (!$region) {
                toast('info', "Region Not Found!");
                redirect(URL_ROOT . "admin/manage-regions");
            }

            if ($region) {
                if ($regions->deleteBy(['region_id' => $id])) {
                    toast("success", "Region Deleted Successfully!");
                    redirect(URL_ROOT . "admin/manage-regions");
                }
            }
            toast("info", "Failure on Deleting process!");
            redirect(URL_ROOT . "admin/manage-regions");
        }
    }

    public function view(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-regions") {
                $output = '';
                $regions = new Regions();

                $data = $regions->getRegions();

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Region</th>
                        <th>Region Info</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-start text-secondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize">' . $row->region . '</td>
                    <td class="text-capitalize">' . $row->region_info . '</td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                        <a href="' . URL_ROOT . "admin/regions/edit/{$row->region_id}" . '" title="Edit Region" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                        <a href="' . URL_ROOT . "admin/regions/delete/{$row->region_id}" . '" title="Delete Region" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No region present in the database!</h3>';
            }
        }
    }

    private function access()
    {
        if (!hasAccess(['admin', 'manager'], 'all', [])) {
            toast("info", "PERMISSION NOT GRANTED!");
            redirect(URL_ROOT . "admin", 401);
        }
    }
}
