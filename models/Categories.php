<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Categories Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Categories extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'create'

    public static function tableName(): string
    {
        return 'categories';
    }

    public function setIsInsertionScenario(string $scenario)
    {
        // You can validate the scenario here if needed
        $this->scenario = $scenario;
    }

    public function rules(string $scenario = null): array
    {
        // Define validation rules for different scenarios
        $rules = [
            'create' => [
                'category' => [
                    ['rule' => 'required', 'message' => 'Category Title is required.'],
                ],
                'category_info' => [
                    ['rule' => 'required', 'message' => 'Category Info is required.'],
                ],
                'section' => [
                    ['rule' => 'required', 'message' => 'Category Section is required.'],
                ],
                'child' => [
                    ['rule' => 'required', 'message' => 'Category Parent is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Category Status is required.'],
                ],
            ],
            'edit' => [
                'category' => [
                    ['rule' => 'required', 'message' => 'Category Title is required.'],
                ],
                'category_info' => [
                    ['rule' => 'required', 'message' => 'Category Info is required.'],
                ],
                'section' => [
                    ['rule' => 'required', 'message' => 'Category Section is required.'],
                ],
                'child' => [
                    ['rule' => 'required', 'message' => 'Category Parent is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Category Status is required.'],
                ],
            ],
        ];

        // Determine the scenario to use or fallback to the default
        $scenario = $scenario ?: $this->scenario;

        return $rules[$scenario] ?? [];
    }

    public function beforeSave(): void
    {
    }

    public function getCategories()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'active'])
            ->get();
    }

    public function getNavbarCategories()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'active', 'section' => 'navbar'])
            ->orderBy("category", "DESC")
            ->get();
    }

    public function getCategoryParent($category_id)
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['category_id' => $category_id, 'status' => 'active', 'section' => 'navbar'])
            ->get();
    }

    public function getCategoryChildren($category_id)
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['child' => $category_id, 'status' => 'active', 'section' => 'navbar'])
            ->get();
    }
}