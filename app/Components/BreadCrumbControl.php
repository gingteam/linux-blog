<?php

declare(strict_types=1);

namespace App\Components;

use Nette\Application\UI\Control;

class BreadCrumbControl extends Control
{
    private $links = [];

    public function add(string $title, string $url = '#')
    {
        $link = new \stdClass();
        $link->title = $title;
        $link->url = $url;

        $this->links[] = $link;

        return $this;
    }

    public function render(string $title)
    {
        $this->template->links = $this->links;
        $this->template->title = $title;
        $this->template->render(__DIR__.'/breadcrumb.latte');
    }
}
