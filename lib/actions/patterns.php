<?php

namespace Gtd\VueEditor\Actions;

use Bitrix\Main\Engine\Controller;
use Gtd\VueEditor\Editor;

class Patterns extends Controller
{
    public function getAction($context = []): array
    {
        $editor = new Editor;
        return $editor->getPatterns($context);
    }
}
