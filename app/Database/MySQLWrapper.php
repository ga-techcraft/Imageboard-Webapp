<?php

namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli{
  public function __construct() {
    // 以下を設定しておくと接続失敗時に例外を投げてくれる。
    // 設定しないと、デフォルトではfalseを投げる。
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $hostname = Settings::env('HOST_NAME');
    $database = Settings::env('DATABASE_NAME');
    $username = Settings::env('DATABASE_USER');
    $password = Settings::env('DATABASE_PASSWORD');

    parent::__construct($hostname, $username, $password, $database);
  }
}