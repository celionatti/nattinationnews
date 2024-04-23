<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Resources Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Resources extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'create'

    public static function tableName(): string
    {
        return 'resources';
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
                'title' => [
                    ['rule' => 'required', 'message' => 'Resource Title is required.'],
                ],
                'content' => [
                    ['rule' => 'required', 'message' => 'Resource Content is required.'],
                ],
                'resource' => [
                    ['rule' => 'required', 'message' => 'Resource File is required.'],
                ],
                'category' => [
                    ['rule' => 'required', 'message' => 'Resource Category is required.'],
                ],
                'thumbnail' => [
                    ['rule' => 'required', 'message' => 'Resource Thumbnail is required.'],
                ],
                'thumbnail_caption' => [
                    ['rule' => 'required', 'message' => 'Resource Thumbnail Caption is required.'],
                ],
                'meta_title' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Title is required.'],
                ],
                'meta_description' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Descriptions is required.'],
                ],
                'meta_keywords' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Keywords is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Resource Status is required.'],
                ],
            ],
            'edit' => [
                'title' => [
                    ['rule' => 'required', 'message' => 'Resource Title is required.'],
                ],
                'content' => [
                    ['rule' => 'required', 'message' => 'Resource Content is required.'],
                ],
                'category' => [
                    ['rule' => 'required', 'message' => 'Resource Category is required.'],
                ],
                'thumbnail' => [
                    ['rule' => 'required', 'message' => 'Resource Thumbnail is required.'],
                ],
                'thumbnail_caption' => [
                    ['rule' => 'required', 'message' => 'Resource Thumbnail Caption is required.'],
                ],
                'meta_title' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Title is required.'],
                ],
                'meta_description' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Descriptions is required.'],
                ],
                'meta_keywords' => [
                    ['rule' => 'required', 'message' => 'Resource Meta Keywords is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Resource Status is required.'],
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
}
