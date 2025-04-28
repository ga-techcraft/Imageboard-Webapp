<?php

namespace Response\Render;

use Response\HTTPRenderer;

class JSONRenderer implements HTTPRenderer {
  private array $data;

  public function __construct(array $data) {
    $this->data = $data;
  }

  public function getField(): array{
    return [
      'Content-Type' => 'application/json; charset=UTF-8',
    ];
  }

  public function getcontent(): string{
    return json_encode($this->data, JSON_THROW_ON_ERROR);
  }
}