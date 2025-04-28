<?php

use Response\Render\HTMLRenderer;

return [
  'path_1' => function(): HTMLRenderer {
    return new HTMLRenderer('view_1');
  },
  'path_2' => 'view_2'
];