<?php

namespace Helpers;

use Exception;

class Settings{
  private static string $envPath = __DIR__ . '/../.env';

  public static function env(string $pair): string {
    $config = parse_ini_file(self::$envPath);
    if (!isset($config[$pair])) throw new Exception('.envファイルに指定されたキーが存在しません。');
    
    return $config[$pair];
  }
}