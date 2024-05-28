<?php

declare(strict_types=1);

/**
 * =============================================
 * ================             ================
 * Users Model
 * ================             ================
 * =============================================
 */

namespace PhpStrike\models;


use celionatti\Bolt\Database\DatabaseModel;

class Users extends DatabaseModel
{
    private $scenario = 'create'; // Default scenario is 'signup'

    public static function tableName(): string
    {
        return 'users';
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
                'surname' => [
                    ['rule' => 'required', 'message' => 'Surname is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Surname is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'name' => [
                    ['rule' => 'required', 'message' => 'Othername is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Othername is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'email' => [
                    ['rule' => 'required', 'message' => 'Email is required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'phone' => [
                    ['rule' => 'required', 'message' => 'Phone Number is Required.'],
                    ['rule' => 'numeric', 'message' => 'Only Numbers are allowed.'],
                ],
                'gender' => [
                    ['rule' => 'required', 'message' => 'Gender is Required.'],
                ],
                'role' => [
                    ['rule' => 'required', 'message' => 'Role are required'],
                ],
                'password' => [
                    ['rule' => 'required', 'message' => 'Password is Required.'],
                    ['rule' => 'securePassword', 'message' => 'Password is not strong enough.'],
                ],
            ],
            'edit' => [
                'surname' => [
                    ['rule' => 'required', 'message' => 'Surname is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Surname is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'name' => [
                    ['rule' => 'required', 'message' => 'Othername is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Othername is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'email' => [
                    ['rule' => 'required', 'message' => 'Email is required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'phone' => [
                    ['rule' => 'required', 'message' => 'Phone Number is Required.'],
                    ['rule' => 'numeric', 'message' => 'Only Numbers are allowed.'],
                ],
                'gender' => [
                    ['rule' => 'required', 'message' => 'Gender is Required.'],
                ],
                'birth_date' => [
                    ['rule' => 'required', 'message' => 'Date Of Birth is Required.'],
                ],
                'bio' => [
                    ['rule' => 'required', 'message' => 'Bio is Required.'],
                ],
                'facebook' => [
                    ['rule' => 'required', 'message' => 'Facebook URL is Required.'],
                ],
                'twitter' => [
                    ['rule' => 'required', 'message' => 'Twitter URL is Required.'],
                ],
                'instagram' => [
                    ['rule' => 'required', 'message' => 'Instagram URL is Required.'],
                ],
            ],
            'login' => [
                'email' => [
                    ['rule' => 'required', 'message' => 'Email is required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'password' => [
                    ['rule' => 'required', 'message' => 'Password is Required.'],
                ],
            ],
            'change-password' => [
                'old_password' => [
                    ['rule' => 'required', 'message' => 'Password is Required.'],
                ],
                'password' => [
                    ['rule' => 'required', 'message' => 'Password is Required.'],
                    ['rule' => 'securePassword', 'message' => 'Password is not strong enough.'],
                ],
                'confirm_password' => [
                    ['rule' => 'required', 'message' => 'Confirm Password is Required.'],
                ],
            ],
            'user-edit' => [
                'surname' => [
                    ['rule' => 'required', 'message' => 'Surname is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Surname is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'name' => [
                    ['rule' => 'required', 'message' => 'Othername is required.'],
                    ['rule' => 'maxLength', 'params' => [15], 'message' => 'Othername is a minimum of 20 characters.'],
                    ['rule' => 'alpha', 'message' => 'Only Alphabet characters are allowed.'],
                ],
                'email' => [
                    ['rule' => 'required', 'message' => 'Email is required.'],
                    ['rule' => 'email', 'message' => 'Email must be a valid email address.'],
                ],
                'phone' => [
                    ['rule' => 'required', 'message' => 'Phone Number is Required.'],
                    ['rule' => 'numeric', 'message' => 'Only Numbers are allowed.'],
                ],
                'gender' => [
                    ['rule' => 'required', 'message' => 'Gender is Required.'],
                ],
                'role' => [
                    ['rule' => 'required', 'message' => 'Role is Required.'],
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
