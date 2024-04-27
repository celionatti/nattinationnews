<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Regions Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Regions extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'create'

    public static function tableName(): string
    {
        return 'regions';
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
                'region' => [
                    ['rule' => 'required', 'message' => 'Region Name is required.'],
                ],
                'region_info' => [
                    ['rule' => 'required', 'message' => 'Region Info is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Region Status is required.'],
                ],
            ],
            'edit' => [
                'region' => [
                    ['rule' => 'required', 'message' => 'Region Name is required.'],
                ],
                'region_info' => [
                    ['rule' => 'required', 'message' => 'Region Info is required.'],
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Region Status is required.'],
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

    public function getRegions()
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'active'])
            ->get();
    }
}