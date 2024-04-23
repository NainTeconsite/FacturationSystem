<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\UserRules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        UserRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $categories = [
        'name' => 'required|min_length[3]|max_length[60]'
    ];
    public $tags = [
        'name' => 'required|min_length[3]|max_length[60]'
    ];
    public $products = [
        'name' => 'required|max_length[255]',
        'code' => [
            'rules' => 'required|alpha_numeric|max_length[20]|greater_than_equal_to[0]',
            'errors' => [
                'is_unique' => 'El código del producto ya existe. Por favor, elige otro.',
            ]
        ],
        'description' => 'required',
        'entry' => 'required|numeric|greater_than_equal_to[0]',
        'exit' => 'required|numeric|greater_than_equal_to[0]',
        'stock' => 'required|numeric|greater_than_equal_to[0]',
        'price' => 'required|numeric|greater_than_equal_to[0]',
        'categoryid' => 'required',
        'tagid' => 'permit_empty',
    ];

}
