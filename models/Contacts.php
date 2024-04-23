<?php

declare(strict_types=1);

/**
 * ======================================
 * ===============        ===============
 * ===== Settings Model
 * ===============        ===============
 * ======================================
 */

namespace PhpStrike\models;

use celionatti\Bolt\Database\DatabaseModel;

class Contacts extends DatabaseModel
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

    public static function tableName():string
    {
        return "contacts";
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
                'email' => [
                    ['rule' => 'required', 'message' => 'Value is Required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'subject' => [
                    ['rule' => 'required', 'message' => 'Value is Required.']
                ],
                'message' => [
                    ['rule' => 'required', 'message' => 'Value is Required.']
                ],
            ],
            'edit' => [
                'name' => [
                    ['rule' => 'required', 'message' => 'Name is required.'],
                    ['rule' => 'alphaWithSpaces', 'message' => 'Only Alphabet and _ - characters are allowed.'],
                ],
                'email' => [
                    ['rule' => 'required', 'message' => 'Value is Required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'subject' => [
                    ['rule' => 'required', 'message' => 'Value is Required.']
                ],
                'message' => [
                    ['rule' => 'required', 'message' => 'Value is Required.']
                ],
            ]
        ];

        // Determine the scenario to use or fallback to the default
        $scenario = $scenario ?: $this->scenario;

        return $rules[$scenario] ?? [];
    }

    public function getMessage($name)
    {
        return $this->findOne(['name' => $name, 'status' => 'active']);
    }

    public function getMessages()
    {
        return $this->findAll();
    }

    public function beforeSave(): void
    {
    }
}