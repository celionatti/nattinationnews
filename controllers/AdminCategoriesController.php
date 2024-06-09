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

        $this->currentUser = user();

        if (is_null($this->currentUser)) {
            redirect(URL_ROOT . "dashboard/login", 401);
        }
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

        // Remove the category data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['category_data']);

        $this->view->render("admin/categories/create", $view);
    }

    public function create(Request $request)
    {
        $this->access(['admin', 'manager']);
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
        $this->access(['admin', 'manager']);
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

        // Remove the article data from the session after it has been retrieved
        Bolt::$bolt->session->unsetArray(['category_data']);

        $this->view->render("admin/categories/edit", $view);
    }

    public function edit(Request $request)
    {
        $this->access(['admin', 'manager']);
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
        $this->access(['admin', 'manager']);
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
        $this->access(['admin', 'manager']);
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

                if (empty($data)) {
                    return '<h3 class="text-center text-secondary mt-5">:( No region present in the database!</h3>';
                }

                $output = $this->generateCategoriesTable($data);
                $this->json_response($output);
            }
        }
    }

    private function generateCategoriesTable($data)
    {
        $output = '<table class="table table-striped table-sm table-bordered">
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
            $output .= $this->generateCategoryRow($key, $row);
        }

        $output .= '</tbody></table>';
        return $output;
    }

    private function generateCategoryRow($key, $row)
    {
        $status = statusVerification($row->status);
        $editUrl = URL_ROOT . "admin/categories/edit/{$row->category_id}";
        $deleteUrl = URL_ROOT . "admin/categories/delete/{$row->category_id}";
        $isChild = $row->child !== "none" ? "text-danger" : "";

        return "
        <tr class='text-start text-secondary'>
            <td>" . ($key + 1) . "</td>
            <td class='text-capitalize {$isChild}'>{$row->category}</td>
            <td class='text-capitalize'>{$row->category_info}</td>
            <td class='text-capitalize'>{$row->section}</td>
            <td class='text-capitalize'>{$status}</td>
            <td>
                <a href='{$editUrl}' title='Edit Category' class='btn btn-sm btn-outline-warning px-3 py-1 my-1'><i class='bi bi-pencil-square'></i></a>
                <a href='{$deleteUrl}' title='Delete Category' class='btn btn-sm btn-outline-danger px-3 py-1 my-1'><i class='bi bi-trash'></i></a>
            </td>
        </tr>";
    }

    private function access(array $data)
    {
        if (!hasAccess($data, 'all', [])) {
            toast("info", "PERMISSION NOT GRANTED!");
            redirect(URL_ROOT . "admin", 401);
        }
    }
}
