<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Comments Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Comments extends DatabaseModel
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
        return "comments";
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
                'comment_text' => [
                    ['rule' => 'required', 'message' => 'Comment is required.'],
                ]
            ]
        ];

        // Determine the scenario to use or fallback to the default
        $scenario = $scenario ?: $this->scenario;

        return $rules[$scenario] ?? [];
    }

    public function beforeSave(): void
    {
    }

    public function getComments($id)
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'active', 'article_id' => $id])
            ->orderBy("created_at", "DESC")
            ->get();
    }

    public function findReplies($id, $comment_id)
    {
        return $this->getQueryBuilder()
            ->select()
            ->where(['status' => 'active', 'article_id' => $id, 'reply_id' => $comment_id])
            ->orderBy("created_at", "DESC")
            ->get();
    }
}
