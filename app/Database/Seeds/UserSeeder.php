<?php

namespace Database\Seeds;

use Database\AbstractSeeder;

class UserSeeder extends AbstractSeeder{
  protected ?string $tableName = 'users';
  protected array $tableColumns = [
    [
      'data_type' => 'string',
      'column_name' => 'name'      
    ],
    [
      'data_type' => 'int',
      'column_name' => 'age'      
    ],
  ];

  public function createRowData(): array{
    return [
      [
        'kotaro',
        28
      ],
      [
        'mei',
        27
      ],
    ];
  }
}