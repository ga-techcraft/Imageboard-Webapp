<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Exception;

class CodeGeneration extends AbstractCommand{
  protected static ?string $alias = 'code-gen';
  protected static bool $requiredCommandValue = true;

  public static function getArguments(): array{
    return [
      (new Argument('name'))
        ->description('生成するコードの名前')
        ->required(true),
    ];
  }

  public function execute(): int{
    // 生成コードの種類を取得
    $type = $this->getCommandValue();

    $name = $this->getArgumentValue('name');
    
    // コマンドコードの生成の場合
    if ($type === 'command') {
      $this->makeCommandFile($name);
    } else if ($type === 'migration') {
      $this->makeMigrationFile($name);
    }

    return 0;
  }

  public function makeCommandFile($name) {
    ob_start();
    include(__DIR__ . '/Templete/Command.php');
    $templeData = ob_get_clean();

    $commandFilePath = sprintf("%s/%s.php", __DIR__, $name);
    file_put_contents($commandFilePath, $templeData);

    $registry = include(__DIR__ . "/../registry.php");
    $registry[] = "Commands\Programs\\$name";
    $array = var_export($registry, true);
    $code = <<<CODE
      <?php
        return $array;
    CODE;
    
    file_put_contents(__DIR__ . "/../registry.php", $code);
  }

  public function makeMigrationFile($name){
    // ファイル名作成
    $filename = sprintf("%s_%s_%s.php", date('Y-m-d'), time(), $name);

    // コンテンツを取得
    $content = include(__DIR__ . '/Templete/Migration.php');

    // パスを取得
    $path = __DIR__ . '/../../Database/Migrations/' . $filename;

    // そのパスにコンテンツを入れる
    file_put_contents($path, $content);
  }
}