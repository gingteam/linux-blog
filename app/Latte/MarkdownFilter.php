<?php

namespace App\Latte;

use App\Tools\Markdown;
use Latte\Runtime\Html;
use Nette\SmartObject;

class MarkdownFilter
{
    use SmartObject;

    public function __invoke(string $text)
    {
        return new Html((new Markdown())->text($text));
    }
}
