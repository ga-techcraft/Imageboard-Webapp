<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;

class Greet extends AbstractCommand {
  protected static ?string $alias = 'greet';

  /** @return Argument[] */
  public static function getArguments(): array{
    return [
      (new Argument('name'))
        ->description('挨拶する相手の名前')
        ->required(true)
        ->allowAsShort(true)
    ];
  }

  public function execute(): int{
    $name = $this->getArgumentValue('name');

    if ($name == false) {
      $this->log('名前が設定されていません。');
      return 1;
    }

    $this->log("こんにちは、{$name}さん！");

    return 0;
  }
}