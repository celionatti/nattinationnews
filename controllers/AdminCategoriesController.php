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
        $view = [
            'title' => 'Manage Categories',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Categories', 'url' => ''],
            ],
        ];

        $this->view->render("admin/categories/manage", $view);
    }

    public function create_category(Request $request)
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
            'title' => 'Create Category',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Create Category', 'url' => ''],
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

        $this->view->render("admin/categories/create", $view);
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
        redirect(URL_ROOT . "admin/categories/create");
    }

    public function edit_category(Request $request)
    {
        $id = $request->getParameter("id");

        $categories = new Categories();

        $categoryList = $categories->findOne([
            'category_id' => $id,
        ]);

        $categorys = $categories->getCategories();

        $categoryOptions = ['none' => 'None'];
        foreach ($categorys as $category) {
            $categoryOptions[$category->category_id] = ucfirst($category->category);
        }

        $view = [
            'errors' => Bolt::$bolt->session->getFormMessage(),
            'category' => $categoryList ?? retrieveSessionData('category_data'),
            'title' => 'Edit Category',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Categories', 'url' => 'admin/manage-categories'],
                ['label' => 'Edit Category', 'url' => ''],
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

        $this->view->render("admin/categories/edit", $view);
    }

    public function edit(Request $request)
    {
        if ($request->isPost()) {
            $id = $request->getParameter("id");

            $categories = new Categories();

            $category = $categories->findOne([
                'category_id' => $id,
            ]);

            if (!$category) {
                toast("info", "Category Not Found!");
                redirect(URL_ROOT . "admin/manage-categories");
            }

            $categories->updatable([
                'category',
                'category_info',
                'section',
                'child',
                'status',
            ]);
            $data = $request->getBody();
            validate_csrf_token($data);

            $categories->setIsInsertionScenario('edit'); // Set insertion scenario flag

            if ($categories->validate($data)) {
                if ($categories->updateBy($data, ['category_id' => $id])) {
                    toast("success", "Category Updated Successfully");
                    redirect(URL_ROOT . "admin/manage-categories");
                }
            } else {
                storeSessionData('category_data', $data);
            }
        }
        toast("info", "No Changes Made - Nothing Was Updated!");
        Bolt::$bolt->session->setFormMessage($categories->getErrors());
        redirect(URL_ROOT . "admin/manage-categories");
    }

    public function delete_category(Request $request)
    {
        $id = $request->getParameter("id");

        $categories = new Categories();

        $category = $categories->findOne([
            'category_id' => $id,
        ]);

        $view = [
            'title' => 'Delete Category',
            'navigations' => [
                ['label' => 'Dashboard', 'url' => 'admin'],
                ['label' => 'Manage Categories', 'url' => 'admin/manage-categories'],
                ['label' => 'Delete Category', 'url' => ''],
            ],
            'category' => $category,
        ];

        $this->view->render("admin/categories/delete", $view);
    }

    public function delete(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            validate_csrf_token($data);

            $id = $request->getParameter("id");

            $categories = new Categories();

            $category = $categories->findOne([
                'category_id' => $id,
            ]);

            if (!$category) {
                toast('info', "Category Not Found!");
                redirect(URL_ROOT . "admin/manage-categories");
            }

            if ($category) {
                if ($categories->deleteBy(['category_id' => $id])) {
                    toast("success", "Category Deleted Successfully!");
                    redirect(URL_ROOT . "admin/manage-categories");
                }
            }
            toast("info", "Failure on Deleting process!");
            redirect(URL_ROOT . "admin/manage-categories");
        }
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
                        <th>Category Info</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';

                foreach ($data as $key => $row) {
                    $output .= '<tr class="text-start text-secondary">
                    <td>' . ($key + 1) . '</td>
                    <td class="text-capitalize ' . ($row->child !== "none" ? "text-danger" : "") . ' ">' . $row->category . '</td>
                    <td class="text-capitalize">' . $row->category_info . '</td>
                    <td class="text-start text-capitalize">' . $row->section . '</td>
                    <td class="text-capitalize">' . statusVerification($row->status) . '</td>
                    <td>
                        <a href="' . URL_ROOT . "admin/categories/edit/{$row->category_id}" . '" title="Edit Category" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i></a>&nbsp;&nbsp;

                        <a href="' . URL_ROOT . "admin/categories/delete/{$row->category_id}" . '" title="Delete Category" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>';
                }
                $output .= '</tbody></table>';
                $this->json_response($output);
            } else {
                return '<h3 class="text-center text-secondary mt-5">:( No setting present in the database!</h3>';
            }
        }
    }
}
