<?php
namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Database\MySQLWrapper;

class Seed extends AbstractCommand{
  protected static ?string $alias = 'seed';
  protected static bool $requiredCommandValue = false; // デフォルトはfalse 

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
    $this->runAllSeeds();
    return 0;
  }

  function runAllSeeds(): void{
    $directoryPath = __DIR__ . '/../../Database/Seeds';

    $files = scandir($directoryPath);

    foreach ($files as $file) {
      if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $className = 'Database\Seeds\\' . pathinfo($file, PATHINFO_FILENAME);
  
        $seeder = new $className(new MySQLWrapper());
        $seeder->seed();
      }
    }
  }
}