<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Advertisements Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Advertisements extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'create'


    /**
     * If incase you are using __construct
     * You also need to bring in the parent parent::__construct()
     */
    public function __construct()
    {
        parent::__construct();

        // Set some default values
        $this->limit = 20;
        $this->order = 'asc';
    }

    public static function tableName(): string
    {
        return "adverts";
    }

    public function setIsInsertionScenario(string $scenario)
    {
        // You can validate the scenario here if needed
        $this->scenario = $scenario;
    }

    /**
     * Validation Mode -- Option One.
     *
     */
    public function rules(string $scenario = null): array
    {
        // Define validation rules for different scenarios
        $rules = [
            'create' => [
                'name' => [
                    ['rule' => 'required', 'message' => 'Name is required.'],
                    ['rule' => 'alphaWithSpaces', 'message' => 'Only Alphabet and _ - characters are allowed.'],
                ],
                'priority' => [
                    ['rule' => 'required', 'message' => 'Priority is Required.']
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Status is Required.']
                ],
            ],
            'edit' => [
                'name' => [
                    ['rule' => 'required', 'message' => 'Name is required.'],
                    ['rule' => 'alphaWithSpaces', 'message' => 'Only Alphabet and _ - characters are allowed.'],
                ],
                'priority' => [
                    ['rule' => 'required', 'message' => 'Priority is Required.']
                ],
                'status' => [
                    ['rule' => 'required', 'message' => 'Status is Required.']
                ]
            ]
        ];

        // Determine the scenario to use or fallback to the default
        $scenario = $scenario ?: $this->scenario;

        return $rules[$scenario] ?? [];
    }

    public function getAdvert($priority)
    {
        return $this->findOne(['priority' => $priority, 'status' => 'open']);
    }

    public function getRandAds($limit)
    {
        // Ensure the limit is an integer to prevent SQL injection
        $limit = (int) $limit;

        // Construct the SQL query
        $query = "
        SELECT *
        FROM adverts
        WHERE status = 'open'
        AND priority != 'banner'
        ORDER BY RAND()
        LIMIT :limit";

        // Execute the query with the provided limit
        return $this->getQueryBuilder()
            ->rawQuery($query, ['limit' => $limit])
            ->get();
    }

    public function getByPriority($priority)
    {
        $query = "SELECT a.*
              FROM adverts a
              WHERE a.status = 'open'
              AND a.priority = :priority
              ORDER BY RAND()";

        return $this->getQueryBuilder()
            ->rawQuery($query, ['priority' => $priority])
            ->get();
    }

    public function getByPriorityLimit($priority, $limit)
    {
        $query = "SELECT a.*
              FROM adverts a
              WHERE a.status = 'open'
              AND a.priority = :priority
              ORDER BY RAND()
              LIMIT :limit";

        return $this->getQueryBuilder()
            ->rawQuery($query, ['priority' => $priority, 'limit' => $limit])
            ->get();
    }

    public function getBanner()
    {
        $query = "SELECT a.*
              FROM adverts a
              WHERE a.status = 'open'
              AND a.priority = :priority
              ORDER BY RAND()
              LIMIT :limit";

        return $this->getQueryBuilder()
            ->rawQuery($query, ['priority' => "banner", 'limit' => 1])
            ->get()[0] ?? [];
    }

    public function getRandomAdvert($priority, $limit)
    {
        $query = "SELECT a.*
              FROM adverts a
              WHERE a.status = 'open'
              AND a.priority = :priority
              ORDER BY RAND()
              LIMIT :limit";

        return $this->getQueryBuilder()
            ->rawQuery($query, ['priority' => $priority, 'limit' => $limit])
            ->get();
    }

    public function beforeSave(): void
    {
    }
}
