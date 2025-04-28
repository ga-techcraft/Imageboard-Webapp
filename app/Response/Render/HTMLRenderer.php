<?php

namespace Response\Render;

use Exception;
use Response\HTTPRenderer;

class HTMLRenderer implements HTTPRenderer {
  private array $data;
  private string $viewFile;

  public function __construct(string $viewFile, array $data = []) {
    $this->data = $data;
    $this->viewFile = $viewFile;
  }

  public function getField(): array{
    return [
      'Content-Type' => 'text/html; charset=UTF-8',
    ];
  }

  public function getContent(): string{
    // viewFileをもとに、そのファイルが存在するかどうか確認
    $viewpath = __DIR__ . '/../../Views/component/' . $this->viewFile . '.php';
    // ヘッダーとフッターも取得し、レンダリングし、それらを返す
    if (!file_exists($viewpath)) {
      echo $viewpath;
      throw new Exception("view file does not exist.");
    }

    ob_start();
    extract($this->data);
    include $viewpath;
    return $this->getHeader() . ob_get_clean() . $this->getFooter();
  }

  private function getHeader(): string{
    ob_start();
    include(__DIR__ . '/../../Views/layout/header.php');
    return ob_get_clean();
  }

  private function getFooter(): string{
    ob_start();
    include(__DIR__ . '/../../Views/layout/footer.php');
    return ob_get_clean();
  }
}