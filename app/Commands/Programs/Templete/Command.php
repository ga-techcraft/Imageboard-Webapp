<?php

echo <<<COMMAND
<?php
namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class $name extends AbstractCommand{
  protected static ?string \$alias = 'aliasName';
  protected static bool \$requiredCommandValue = false; // デフォルトはfalse 

  public static function getArguments(): array{
    return [
      // ここに引数のインスタンスをいれる

      // 以下は例
      // (new Argument('name'))
      // ->description('挨拶する相手の名前')
      // ->required(true) // デフォルトはtrue
      // ->allowAsShort(true)
    ];
  }

  public function execute(): int{
    // ここにコマンドができる処理をいれる

    return 0;
  }
}
COMMAND;