<?php
spl_autoload_extensions(".php");
spl_autoload_register(function($class) {
    $file = __DIR__ . '/../'  . str_replace('\\', '/', $class). '.php';
    if (file_exists(stream_resolve_include_path($file))) include($file);
});

// ルートを読み込む
$routes = include('../Routing/routes.php');

// リクエストURLを取得、以下にはクエリも含まれる
$requestURI = $_SERVER['REQUEST_URI'];

// 以下でパスのみにして、最初の'/'を除く
$path = parse_url($requestURI, PHP_URL_PATH);
$path = trim($path, '/');

if (isset($routes[$path])) {
    $render = $routes[$path]();

    foreach ($render->getField() as $name => $value) {
        header("$name: $value");
        print($render->getContent());
    }
    
    try {
    
    } catch (Exception $e) {
        http_response_code(500);
        echo "505 Internal error: サーバー側で予期せぬエラーが発生しました。";
        print($e->getMessage());
    }

} else {
    http_response_code(404); // not found
    echo "404 Not Found: リクエストされたパスが存在しません。";
}




?>