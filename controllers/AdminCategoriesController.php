<?php

declare(strict_types=1);

/**
 * ===============================================
 * ==================           ==================
 * ****** AdminCategoriesController
 * ==================           ==================
 * ===============================================
 */

namespace PhpStrike\controllers;

use celionatti\Bolt\Bolt;

use celionatti\Bolt\Controller;
use celionatti\Bolt\Http\Request;
use PhpStrike\models\Categories;

class AdminCategoriesController extends Controller
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
        $categories = new Categories();

        $categorys = $categories->getCategories();

        $categoryOptions = ['none' => 'None'];
        foreach ($categorys as $category) {
            $categoryOptions[$category->category_id] = ucfirst($category->category);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'category' => retrieveSessionData('category_data'),
            'title' => 'Manage Categories',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Categories', 'url' => ''],
            ],
            'categoryOpts' => $categoryOptions,
            'sectionOpts' => [
                'none' => 'None',
                'navbar' => 'Navbar',
                'sidebar' => 'Sidebar',
                'footer' => 'Footer',
                'footer_sidebar' => 'Footer & Sidebar',
            ],
            'statusOpts' => [
                'disable' => 'Disable',
                'active' => 'Active',
            ],
        ];

        $this->view->render("admin/categories/manage", $view);
    }

    public function create(Request $request)
    {
        if ($request->isPost()) {
            $categories = new Categories();

            $categories->fillable([
                'category_id',
                'category',
                'category_info',
                'section',
                'child',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);
            $data['category_id'] = generateUuidV4();

            $categories->setIsInsertionScenario('create'); // Set insertion scenario flag

            if ($categories->validate($data)) {
                if ($categories->insert($data)) {
                    toast("success", "Category Created Successfully");
                    redirect(URL_ROOT . "admin/manage-categories");
                }
            } else {
                storeSessionData('category_data', $data);
            }
        }
        toast("error", "Category Creation Failed!");
        Bolt::$bolt->session->setFormMessage($categories->getErrors());
        redirect(URL_ROOT . "admin/manage-categories");
    }

    public function view(Request $request)
    {
        if ($request->isPost()) {
            if ($request->post('action') && $request->post('action') === "view-categories") {
                $output = '';
                $categories = new Categories();

                $data = $categories->getCategories();

                $output .= '<table class="table table-striped table-sm table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Category</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-start text-scondary">
                    <td>' . $key + 1 . '</td>
                    <td class="text-capitalize">' . $row->category . '</td>
                    <td class="text-start text-capitalize">' . $row->section . '</td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                    <a href="' . URL_ROOT . "admin/preview-category/{$row->category_id}" . '" title="Edit Category" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/edit-category/{$row->category_id}" . '" title="Edit Category" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                    <a href="' . URL_ROOT . "admin/delete-category/{$row->category_id}" . '" title="Delete Category" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                    </td></tr>
                    ';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No setting present in the database!</h3>';
            }
        }
    }
}
