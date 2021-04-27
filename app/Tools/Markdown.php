<?php

namespace App\Tools;

class Markdown extends \Parsedown
{
    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);

        if (!isset($image)) {
            return null;
        }

        $image['element']['attributes']['class'] = 'img-fluid';

        return $image;
    }

    protected function blockTable($Line, ?array $Block = null)
    {
        $table = parent::blockTable($Line, $Block);

        if (!isset($table)) {
            return null;
        }

        $table['element']['attributes']['class'] = 'table table-bordered';

        return $table;
    }

    protected function blockQuote($Line)
    {
        $quote = parent::blockQuote($Line);

        if (!isset($quote)) {
            return null;
        }

        $quote['element']['attributes']['class'] = 'blockquote';

        return $quote;
    }

    protected function inlineColoredText($excerpt)
    {
        if (preg_match('/^{c:([#\w]\w+)}(.*?){\/c}/', $excerpt['text'], $matches)) {
            return [
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'span',
                    'text' => $matches[2],
                    'attributes' => [
                        'style' => 'color: '.$matches[1],
                    ],
                ],
            ];
        }
    }
}
